<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

/** @noinspection RealpathInSteamContextInspection */
$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();
$app->withEloquent();

//Config autoload
foreach (scandir(__DIR__ . '/../config/', SCANDIR_SORT_NONE) as $item) {
    if (ends_with($item, '.php')) {
        $app->configure(substr($item, 0, -4));
    }
}

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Filesystem\Factory::class,
    function ($app) {
        return new Illuminate\Filesystem\FilesystemManager($app);
    }
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware(array(
    'user_type' => App\Http\Middleware\UserTypeMiddleware::class,
    'params' => \App\Http\Middleware\RouterParamsInParamBagMiddleware::class
));
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(Spatie\Fractal\FractalServiceProvider::class);
$app->register(\Illuminate\Mail\MailServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);

//
//if ($app->environment() === 'production') {
//    $app->bind(\App\Exceptions\Handler::class, \App\Exceptions\JsonHandler::class);
//}

if ($app->environment() === 'local') {
    $app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    $app->register(\Laravel\Tinker\TinkerServiceProvider::class);
}


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

/** @noinspection PhpUnusedParameterInspection */
$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
