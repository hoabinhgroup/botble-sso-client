<?php

namespace Botble\SsoLogin\Providers;

use Botble\SsoLogin\Models\SsoLogin;
use Illuminate\Support\ServiceProvider;
use Botble\Base\Supports\Helper;
use Botble\SsoLogin\Facades\SsoServiceFacade;
use Illuminate\Foundation\AliasLoader;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class SsoLoginServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/sso-login')
            ->loadAndPublishConfigurations(['permissions','general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        AliasLoader::getInstance()->alias('SsoService', SsoServiceFacade::class);

        Event::listen(RouteMatched::class, function () {

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-sso-login',
                'priority'    => 5,
                'parent_id'   => 'cms-core-settings',
                'name'        => 'plugins/sso-login::sso-login.name',
                'icon'        => '',
                'url'         => route('sso-login.settings'),
                'permissions' => ['sso-login.settings'],
            ]);
        });

        $this->app->register(HookServiceProvider::class);
    }
}
