<?php

declare(strict_types=1);

use EaseAppPHP\HighPer\Framework\Core\Application;

return function (Application $app) {
    $router = $app->getRouter();
    
    // Define web routes
    $router->get('/', 'App\\Controllers\\Web\\HomeController@index');
    $router->get('/about', 'App\\Controllers\\Web\\HomeController@about');
    $router->get('/contact', 'App\\Controllers\\Web\\HomeController@contact');
    $router->post('/contact', 'App\\Controllers\\Web\\HomeController@submitContact');
};
