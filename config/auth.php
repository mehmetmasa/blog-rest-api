<?php

use App\Models\Author;
use App\Models\Admin;

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],
    'guards' => [
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'passport',
            'provider' => 'admins',
        ]
    ],
    'providers' => [
        'authors' => [
            'driver' => 'eloquent',
            'model' => Author::class
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => Admin::class
        ]
    ]
];
