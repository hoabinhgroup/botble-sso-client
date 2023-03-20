<?php

return [
    'name'   => 'Sso logins',
    'settings' => [
        'title'       => 'SSO Login settings',
        'description' => 'Configure SSO Login options',
        'enable'      => 'Enable?',
        'clientId'    => 'Client ID',
        'clientSecret' => 'Client Secret',
        'callback'  => 'Callback Url',
        'sso_login_button_name'  => 'Login Button Name',
        'authorize_endpoint'  => 'Authorize Endpoint',
        'access_token_endpoint'  => 'Access Token Endpoint',
        'user_info_endpoint'  => 'Get User Info Endpoint',
        'redirect_after_login'  => 'Redirect Url After Login SSO',
        'attribute_mapping'  => 'Atribute Mapping',
        'attribute_mapping_description'  => 'Atribute Mapping First Name, Last Name, Email, Role',
        'sso_first_name'  => 'First Name',
        'sso_last_name'  => 'Last Name',
        'sso_email'  => 'Email',
        'sso_permission'  => 'Set permission',
    ],
    'menu'     => 'SSO Login',
];
