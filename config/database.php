<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | The framework supports various database systems including MySQL,
    | PostgreSQL, SQLite, and MongoDB. Choose the best for your needs.
    |
    */
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'highper'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options' => [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'highper'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '27017'),
            'database' => env('DB_DATABASE', 'highper'),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'options' => [
                'appname' => env('APP_NAME', 'Highper Blueprint Application'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Connection Pool Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection pool settings for each database
    | connection. The connection pool is used to efficiently reuse database
    | connections across multiple requests.
    |
    */
    'pool' => [
        'mysql' => [
            'min_connections' => (int) env('DB_POOL_MIN', 2),
            'max_connections' => (int) env('DB_POOL_MAX', 10),
            'idle_timeout' => (int) env('DB_POOL_IDLE_TIMEOUT', 60),
            'wait_timeout' => (int) env('DB_POOL_WAIT_TIMEOUT', 5),
            'max_wait_queue' => (int) env('DB_POOL_MAX_WAIT_QUEUE', 100),
        ],
        'pgsql' => [
            'min_connections' => (int) env('DB_POOL_MIN', 2),
            'max_connections' => (int) env('DB_POOL_MAX', 10),
            'idle_timeout' => (int) env('DB_POOL_IDLE_TIMEOUT', 60),
            'wait_timeout' => (int) env('DB_POOL_WAIT_TIMEOUT', 5),
            'max_wait_queue' => (int) env('DB_POOL_MAX_WAIT_QUEUE', 100),
        ],
        'mongodb' => [
            'min_connections' => (int) env('DB_POOL_MIN', 2),
            'max_connections' => (int) env('DB_POOL_MAX', 10),
            'idle_timeout' => (int) env('DB_POOL_IDLE_TIMEOUT', 60),
            'wait_timeout' => (int) env('DB_POOL_WAIT_TIMEOUT', 5),
            'max_wait_queue' => (int) env('DB_POOL_MAX_WAIT_QUEUE', 100),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */
    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Settings
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system.
    | Here you may specify the Redis connection settings.
    |
    */
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => (int) env('REDIS_DB', 0),
        ],
        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => (int) env('REDIS_CACHE_DB', 1),
        ],
        'queue' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => (int) env('REDIS_QUEUE_DB', 2),
        ],
    ],
];
            