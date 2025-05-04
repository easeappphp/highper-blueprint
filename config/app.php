<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'name' => env('APP_NAME', 'Highper Blueprint Application'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */
    'environment' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the framework to properly generate URLs when using
    | the URL helper. You should set this to the root of your application.
    |
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions.
    |
    */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Server Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the host and port for the server to listen on.
    | These values are used when running the application via the CLI server.
    |
    */
    'host' => env('APP_HOST', '0.0.0.0'),
    'port' => (int) env('APP_PORT', 8080),

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the service providers which will be registered
    | for your application. Service providers are responsible for bootstrapping
    | any services your application might need.
    |
    */
    'providers' => [
        // Framework Service Providers
        EaseAppPHP\HighPer\Framework\Providers\RouteServiceProvider::class,
        EaseAppPHP\HighPer\Framework\Providers\EventServiceProvider::class,
        
        // Application Service Providers
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Concurrency Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of workers and the worker pool configuration.
    |
    */
    'concurrency' => [
        'worker_pool' => [
            'min_workers' => (int) env('APP_MIN_WORKERS', 2),
            'max_workers' => (int) env('APP_MAX_WORKERS', 8),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | This path is used to determine the base path of the application.
    |
    */
    'base_path' => dirname(__DIR__),
];
