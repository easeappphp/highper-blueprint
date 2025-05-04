<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    'default' => env('LOG_CHANNEL', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. The
    | framework uses the AmPHP Log API to provide a variety of log handlers.
    | You may configure additional channels as needed.
    |
    | Available Drivers: "file", "console", "syslog", "null"
    |
    */
    'channels' => [
        'file' => [
            'type' => 'stream',
            'path' => env('LOG_PATH', storage_path('logs/app.log')),
            'level' => env('LOG_LEVEL', 'info'),
            'formatter' => env('LOG_FORMATTER', 'json'),
            'max_files' => 7,
        ],
        
        'console' => [
            'type' => 'console',
            'level' => env('LOG_LEVEL', 'info'),
        ],
        
        'syslog' => [
            'type' => 'syslog',
            'facility' => LOG_USER,
            'level' => env('LOG_LEVEL', 'info'),
            'formatter' => 'json',
        ],
        
        'null' => [
            'type' => 'null',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Asyncronous Logging
    |--------------------------------------------------------------------------
    |
    | This option allows you to enable or disable asynchronous logging. When
    | enabled, log messages will be queued and processed in a background
    | worker, avoiding blocking the main thread during request handling.
    |
    */
    'async' => (bool) env('LOG_ASYNC', true),

    /*
    |--------------------------------------------------------------------------
    | Log Queue Size
    |--------------------------------------------------------------------------
    |
    | This option specifies the maximum number of log messages to queue for
    | asynchronous processing. If the queue is full, new log messages will
    | be processed synchronously to avoid losing important log data.
    |
    */
    'queue_size' => (int) env('LOG_QUEUE_SIZE', 1000),
    
    /*
    |--------------------------------------------------------------------------
    | Context Data
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional context data that should be included
    | with every log message. This is useful for adding application-wide
    | metadata to your logs.
    |
    */
    'context' => [
        'app' => env('APP_NAME', 'Highper Blueprint Application'),
        'environment' => env('APP_ENV', 'production'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Log Line Format
    |--------------------------------------------------------------------------
    |
    | When using the "line" formatter, this value will be used as the format
    | string. You may customize the format to include any information you
    | need in your logs.
    |
    */
    'line_format' => env(
        'LOG_LINE_FORMAT',
        '[%datetime%] %channel%.%level%: %message% %context% %exception%'
    ),
];
