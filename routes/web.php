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
        $app->get('/auth/firebase/token', 'AuthController@firebaseToken');

        $app->group(['prefix' => '/settings'], function () use ($app) {
            $app->get('/info', 'SettingsController@getInfo');
            $app->put('/password', 'SettingsController@password');
            $app->post('/avatar', 'SettingsController@avatar');
        });

        $app->group(['prefix' => '/client', 'middleware' => ['user_type:client', 'accepted_only'], 'namespace' => 'Client'], function () use ($app) {
            $app->group(['prefix' => '/events'], function () use ($app) {
                $app->get('/', 'EventController@get');
            });

            $app->group(['prefix' => '/templates'], function () use ($app) {
                $app->get('/', 'TemplateController@get');

                $app->group(['prefix' => '/{template_id:[\d]+}'], function () use ($app) {
                    $app->get('/', 'TemplateController@getById');

                    $app->group(['prefix' => '/exercises'], function () use ($app) {
                        $app->group(['prefix' => '/{template_exercise_id:[\d]+}'], function () use ($app) {
                            $app->post('/submit', 'TemplateController@submit');
                        });
                    });
                });
            });
        });

        $app->group(['prefix' => '/trainer', 'middleware' => 'user_type:trainer', 'namespace' => 'Trainer'], function () use ($app) {
            $app->group(['prefix' => '/payments'], function () use ($app) {
                $app->post('/subscription', 'PaymentController@setSubscription');
            });

            $app->group(['middleware' => 'subscription_valid'], function () use ($app) {
                $app->group(['prefix' => '/events'], function () use ($app) {
                    $app->get('/', 'EventController@get');
                    $app->post('/', 'EventController@create');

                    $app->group(['prefix' => '/{event_id:[\d]+}'], function () use ($app) {
                        $app->put('/', 'EventController@edit');
                        $app->delete('/', 'EventController@delete');
                    });
                });

                $app->group(['prefix' => '/categories'], function () use ($app) {
                    $app->get('/', 'ExerciseController@getCategories');

                    $app->group(['prefix' => '/{category_id:[\d]+}'], function () use ($app) {
                        $app->get('/', 'ExerciseController@getCategoryById');
                        $app->get('/exercises', 'ExerciseController@getExercises');
                    });
                });

                $app->group(['prefix' => '/saved-templates'], function () use ($app) {
                    $app->get('/', 'SavedTemplateController@get');
                    $app->post('/', 'SavedTemplateController@create');

                    $app->group(['prefix' => '/{saved_template_id:[\d]+}'], function () use ($app) {
                        $app->get('/', 'SavedTemplateController@getById');
                        $app->put('/', 'SavedTemplateController@update');
                        $app->delete('/', 'SavedTemplateController@delete');
                    });
                });

                $app->group(['prefix' => '/exercises'], function () use ($app) {
                    $app->post('/search', 'ExerciseController@search');
                });

                $app->group(['prefix' => '/clients'], function () use ($app) {
                    $app->get('/', 'ClientController@get');
                    $app->get('/invitation-code', 'ClientController@invitaionCode');

                    $app->group(['prefix' => '/pending'], function () use ($app) {
                        $app->get('/', 'ClientController@pending');
                        $app->post('/{client_id:[\d]+}/accept', 'ClientController@accept');
                        $app->post('/{client_id:[\d]+}/reject', 'ClientController@reject');
                    });

                    $app->group(['prefix' => '/{client_id:[\d]+}'], function () use ($app) {

                        $app->post('/assign/{template_id:[\d]+}', 'ClientController@assign');


                        $app->group(['prefix' => '/templates'], function () use ($app) {
                            $app->get('/', 'TemplateController@get');
                            $app->post('/', 'TemplateController@create');

                            $app->group(['prefix' => '/{template_id:[\d]+}'], function () use ($app) {
                                $app->get('/', 'TemplateController@getById');
                                $app->put('/', 'TemplateController@edit');
                                $app->delete('/', 'TemplateController@delete');

                                $app->group(['prefix' => '/exercises'], function () use ($app) {
                                    $app->group(['prefix' => '/{exercise_id:[\d]+}'], function () use ($app) {
                                        $app->delete('/', 'TemplateController@deleteExercise');
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    });
});
