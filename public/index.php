<?php

declare(strict_types=1);

use EaseAppPHP\HighPer\Framework\Core\Application;
use EaseAppPHP\HighPer\Framework\Core\Bootstrap;

// Define the application base path
define('BASE_PATH', __DIR__);

// Require the Composer autoloader
require BASE_PATH . '/../vendor/autoload.php';

// Create the application
$app = new Application(BASE_PATH);

// Bootstrap the application
$bootstrap = new Bootstrap($app);
$bootstrap->bootstrap();

// Run the application
$app->run();
