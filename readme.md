# Highper Framework

Highper is a high-performance, asynchronous PHP framework specifically designed for microservices that can handle extreme concurrency (C10M - 10 million concurrent connections).

## Features

- **Asynchronous Execution** - Non-blocking I/O operations using RevoltPHP event loop
- **Extreme Concurrency** - Support for C10M (10 million concurrent connections)
- **PSR Compliant** - Follows PSR-3, PSR-4, PSR-7, PSR-11, PSR-15, PSR-18 standards
- **12-Factor Methodology** - Built according to the 12-factor app principles
- **High Performance** - Faster than OpenSwoole, Workerman, and ActiveJ (Java)
- **Modern PHP** - Built with PHP 8.2+ features, leveraging attributes, enums, and typed properties
- **Containerization** - Designed for container environments like Docker and Kubernetes
- **Observability** - Built-in support for logging, metrics, and distributed tracing
- **Security** - Security-focused design with built-in protections
- **Scalability** - Horizontal and vertical scaling support

## Requirements

- PHP 8.2 or higher
- Composer 2.0 or higher
- libuv extension (optional, for optimal performance)

## Installation

### Create a new project

```bash
composer create-project easeappphp/highper-blueprint my-microservice
cd my-microservice
```

### Install as a dependency in an existing project

```bash
composer require easeappphp/highper
```

## Quick Start

### Create a simple API endpoint

```php
<?php

use EaseAppPHP\HighPer\Framework\Core\Application;

// Create the application
$app = new Application(__DIR__);

// Define a route
$app->getRouter()->get('/api/hello', function ($request) {
    return [
        'message' => 'Hello, World!',
        'timestamp' => time(),
    ];
});

// Run the application
$app->run();
```

### Run the application

```bash
php -S localhost:8080 public/index.php
```

Visit http://localhost:8080/api/hello in your browser or use curl:

```bash
curl http://localhost:8080/api/hello
```

## Architecture

Highper follows a clean, modular architecture that separates concerns and promotes testability:

- **Core** - Application bootstrap and service provider system
- **HTTP** - Request/response handling, routing, and middleware
- **Container** - Dependency injection container (Laravel Container)
- **Event Loop** - Asynchronous event loop (RevoltPHP)
- **Concurrency** - Async operations for file, database, and external services
- **WebSocket** - Support for real-time communication
- **Logging** - Async logging with structured data
- **Tracing** - Distributed tracing with OpenTelemetry
- **Configuration** - Environment-based configuration system
- **Security** - Security middleware and utilities

## Examples

### Creating a RESTful API Controller

```php
<?php

namespace App\Controllers\Api;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use EaseAppPHP\HighPer\Framework\API\ApiController;

class UserController extends ApiController
{
    public function index(Request $request): Response
    {
        $users = $this->container->get(UserRepository::class)->all();
        return $this->success($users);
    }
    
    public function show(Request $request): Response
    {
        $id = $this->getParam($request, 'id');
        $user = $this->container->get(UserRepository::class)->find($id);
        
        if (!$user) {
            return $this->notFound('User not found');
        }
        
        return $this->success($user);
    }
}
```

### WebSocket Chat Server

```php
<?php

namespace App\WebSocket;

use EaseAppPHP\HighPer\Framework\WebSocket\WebSocketConnection;
use EaseAppPHP\HighPer\Framework\WebSocket\WebSocketHandlerInterface;

class ChatHandler implements WebSocketHandlerInterface
{
    protected array $clients = [];
    
    public function onConnect(WebSocketConnection $connection): void
    {
        $this->clients[$connection->getId()] = $connection;
        $this->broadcast("User {$connection->getId()} joined the chat");
    }
    
    public function onMessage(WebSocketConnection $connection, $message): void
    {
        $this->broadcast("User {$connection->getId()}: {$message}");
    }
    
    public function onDisconnect(WebSocketConnection $connection): void
    {
        unset($this->clients[$connection->getId()]);
        $this->broadcast("User {$connection->getId()} left the chat");
    }
    
    protected function broadcast(string $message): void
    {
        foreach ($this->clients as $client) {
            if ($client->isOpen()) {
                $client->send($message);
            }
        }
    }
}
```

## Documentation

For complete documentation, please visit [docs.easeapp.org](https://docs.easeapp.org).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

Highper Framework is open-sourced software licensed under the [MIT license](LICENSE).
