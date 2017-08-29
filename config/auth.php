<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-31
 * Time: 11:58
 */
return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt_extended',
            'provider' => 'users'
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
];