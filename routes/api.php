<?php

declare(strict_types=1);

use EaseAppPHP\HighPer\Framework\Core\Application;

return function (Application $app) {
    $router = $app->getRouter();
    
    // Define API routes
    $router->group('/api', function ($router) {
        // API version 1
        $router->group('/v1', function ($router) {
            // Users
            $router->get('/users', 'App\\Controllers\\Api\\UserController@index');
            $router->post('/users', 'App\\Controllers\\Api\\UserController@store');
            $router->get('/users/{id}', 'App\\Controllers\\Api\\UserController@show');
            $router->put('/users/{id}', 'App\\Controllers\\Api\\UserController@update');
            $router->delete('/users/{id}', 'App\\Controllers\\Api\\UserController@destroy');
            
            // Authentication
            $router->post('/auth/login', 'App\\Controllers\\Api\\AuthController@login');
            $router->post('/auth/register', 'App\\Controllers\\Api\\AuthController@register');
            $router->post('/auth/logout', 'App\\Controllers\\Api\\AuthController@logout');
            $router->get('/auth/me', 'App\\Controllers\\Api\\AuthController@me');
        });
    });
    
};
