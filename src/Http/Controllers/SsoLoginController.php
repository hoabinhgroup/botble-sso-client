<?php

namespace Botble\SsoLogin\Http\Controllers;

use Botble\SsoLogin\Http\Requests\SsoLoginRequest;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Exception;
use Botble\ACL\Models\User;
use Botble\ACL\Models\Role;
use Botble\Setting\Supports\SettingStore;
use Botble\Base\Http\Responses\BaseHttpResponse;


class SsoLoginController extends BaseController
{

    public function __construct()
    {}

    public function getLogin(Request $request) {

       // dd(setting('authorize_endpoint'));
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            "client_id" => setting('sso_login_client_id'),
            "redirect_uri" => route('sso-login.callback'),
            "response_type" => "code",
            "scope" => "",
            "state" => $state,
        ]);
        return redirect(setting('authorize_endpoint') . "?" . $query);
    }

    public function getCallback(Request $request) {
         $state = $request->session()->pull("state");
         // dd($state);
         throw_unless(strlen($state) > 0 && $state == $request->state,
             InvalidArgumentException::class);

         $response = Http::asForm()->post(
             setting('access_token_endpoint'),
             [
                 "grant_type" => "authorization_code",
                 "client_id" => setting('sso_login_client_id'),
                 "client_secret" => setting('sso_login_client_secret'),
                 "redirect_uri" => route('sso-login.callback'),
                 "code" => $request->code,
             ]);
         $request->session()->put($response->json());
         return redirect(route('sso-login.connect'));
    }

    public function connect(Request $request) {
        $access_token = $request->session()->get("access_token");
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $access_token
        ])->get(setting('user_info_endpoint'));
        $userArray = $response->json();
        try {
            $email = $userArray['email'];

        } catch (\Throwable $th) {
            return redirect('login')->withError('Failed to get login information! Try again.');
        }
        $user = User::where('email', $email)->first();
        //dd($userArray);
        if(!$user){
            $user = new User;
            $user->first_name = setting('sso_first_name') ?? $userArray['first_name'];
            $user->last_name = setting('sso_last_name') ?? $userArray['last_name'];
            $user->email = setting('sso_email') ?? $userArray['email'];
            if(setting('sso_permission')){
                $user->permissions = Role::find(setting('sso_permission'))->permissions;
            }
            $user->save();

        }
        Auth::login($user);
        return redirect(setting('redirect_after_login') ?? route('dashboard.index'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettings()
    {
        page_title()->setTitle(trans('plugins/sso-login::sso-login.name'));
       // Assets::addScriptsDirectly('vendor/core/plugins/social-login/js/social-login.js');

        return view('plugins/sso-login::settings');
    }

    /**
     * @param SocialLoginRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     */
    public function postSettings(Request $request, BaseHttpResponse $response, SettingStore $setting)
    {
        foreach ($request->except(['_token']) as $settingKey => $settingValue) {
            $setting->set($settingKey, $settingValue);
        }

        $setting->save();

        return $response
            ->setPreviousUrl(route('sso-login.settings'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
