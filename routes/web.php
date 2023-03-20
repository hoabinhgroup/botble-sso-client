<?php

Route::group(['namespace' => 'Botble\SsoLogin\Http\Controllers', 'middleware' => 'web'], function () {

      Route::get('sso/login', [
              'as'   => 'sso-login.login',
              'uses' => 'SsoLoginController@getLogin',
         ]);

       Route::get('sso/callback', [
             'as'   => 'sso-login.callback',
             'uses' => 'SsoLoginController@getCallback',
        ]);

       Route::get('sso/connect', [
            'as'   => 'sso-login.connect',
            'uses' => 'SsoLoginController@connect',
       ]);

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'sso-logins', 'as' => 'sso-login.'], function () {
           Route::get('settings', [
               'as'   => 'settings',
               'uses' => 'SsoLoginController@getSettings',
           ]);

           Route::post('settings', [
               'as'   => 'settings',
               'uses' => 'SsoLoginController@postSettings',
           ]);



        });
    });

});
