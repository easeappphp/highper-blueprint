<?php

declare(strict_types=1);

return [
    'title' => 'PHP Microservice Framework Benchmark',
    'concurrency' => 500,
    'duration' => 30,
    'warmup' => 5,
    'frameworks' => [
        'Highper' => [
            'url' => 'http://localhost:8080/api/benchmark',
            'server_command' => 'php -S localhost:8080 -t public',
            'memory_command' => 'ps -o rss= -p $(lsof -t -i:8080)',
        ],
        'OpenSwoole' => [
            'url' => 'http://localhost:9501/api/benchmark',
            'server_command' => 'php server.php start',
            'memory_command' => 'ps -o rss= -p $(lsof -t -i:9501)',
        ],
        'Workerman' => [
            'url' => 'http://localhost:2345/api/benchmark',
            'server_command' => 'php workerman.php start',
            'memory_command' => 'ps -o rss= -p $(lsof -t -i:2345)',
        ],
        'ActiveJ' => [
            'url' => 'http://localhost:8080/api/benchmark',
            'server_command' => 'java -jar target/activej-benchmark.jar',
            'memory_command' => 'ps -o rss= -p $(lsof -t -i:8080)',
        ],
    ],
];
