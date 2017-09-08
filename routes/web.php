<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => '/v1'], function () use ($app) {
    $app->get('/emails/{destination}/{hash}', ['uses' => 'EmailController@redirect', 'as' => 'email']);


    $app->group(['prefix' => '/auth'], function () use ($app) {
        $app->get('/refresh', ['uses' => 'AuthController@refresh', 'middleware' => 'jwt.refresh']);

        $app->post('/login', 'AuthController@login');

        $app->post('/forgot-password', 'AuthController@forgotPassword');
        $app->post('/set-password', 'AuthController@setPassword');

        $app->post('/register/{user_type:client|trainer}', 'AuthController@register');
        $app->get('/register/trainers', 'AuthController@getTrainers');
    });

    $app->group(['middleware' => 'jwt.auth'], function () use ($app) {
        $app->post('/auth/logout', 'AuthController@logout');

        $app->group(['prefix' => '/settings'], function () use ($app) {
            $app->put('/password', 'SettingsController@password');
            $app->post('/avatar', 'SettingsController@avatar');
        });

        $app->group(['prefix' => '/client', 'middleware' => 'user_type:client', 'namespace' => 'Client'], function () {

        });

        $app->group(['prefix' => '/trainer', 'middleware' => 'user_type:trainer', 'namespace' => 'Trainer'], function () {

        });
    });
});
