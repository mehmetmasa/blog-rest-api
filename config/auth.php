<?php

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
        'admins' => [
            'driver' => 'eloquent',
            'model' => Admin::class
        ]
    ]
];
