<?php

namespace Botble\SsoLogin\Providers;

use Illuminate\Support\ServiceProvider;
use SsoService;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (setting('sso_login_enable', false)) {
            add_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, [$this, 'addLoginOptions'], 25, 2);
        }
    }

    /**
     * @param string $html
     * @param string $module
     * @return null|string
     * @throws \Throwable
     */
    public function addLoginOptions($html, $module)
    {

        if (!SsoService::isSupportedModule($module)) {
            return $html;
        }

        return $html . view('plugins/sso-login::login-options')->render();
    }
}
