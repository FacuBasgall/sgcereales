<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List your email providers
    |--------------------------------------------------------------------------
    |
    | Enjoy a life with multimail
    |
    */
    'use_default_mail_facade_in_tests' => true,

    'emails'  => [
        'facubasgall@gmail.com' => [
            'pass'          => env('MAIL_PASSWORD'),
            'username'      => env('MAIL_USERNAME'),
            'from_name'     => 'Facu Basgall',
        ],
        'berniigotte@gmail.com'  => [
            'pass'     => env('second_mail_password'),
            'username'      => env('second_mail_username'),
            'from_name'     => 'Berni Gotte',
        ],
    ],

    'provider' => [
        'default' => [
            'host'      => env('MAIL_HOST'),
            'port'      => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
        ],
    ],

];
