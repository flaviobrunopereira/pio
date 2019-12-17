<?php

return [

    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'pio'),
            'username'  => env('DB_USERNAME', 'pio'),
            'password'  => env('DB_PASSWORD', 'pio'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'mysql_siges' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST2', 'localhost'),
            'database'  => env('DB_DATABASE2', 'siges'),
            'username'  => env('DB_USERNAME2', 'siges'),
            'password'  => env('DB_PASSWORD2', 'siges'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'mysql_giaf' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST3', 'localhost'),
            'database'  => env('DB_DATABASE3', 'giaf'),
            'username'  => env('DB_USERNAME3', 'giaf'),
            'password'  => env('DB_PASSWORD3', 'giaf'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]
    ],

    'migrations' => 'migrations',

];
