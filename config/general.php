<?php

use Botble\Member\Models\Member;
use Botble\ACL\Models\User;

return [
    'supported' => [
        Member::class,
        User::class
    ],
];
