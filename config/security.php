<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the security headers that should be sent with
    | every response. These headers help protect against common web attacks.
    |
    */
    'headers' => [
        'x-content-type-options' => 'nosniff',
        'x-frame-options' => 'SAMEORIGIN',
        'x-xss-protection' => '1; mode=block',
        'referrer-policy' => 'strict-origin-when-cross-origin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy (CSP)
    |--------------------------------------------------------------------------
    |
    | The Content Security Policy helps prevent unwanted content from being
    | injected into your website. This includes XSS and data injection attacks.
    |
    */
    'csp' => [
        'enabled' => (bool) env('SECURITY_CSP_ENABLED', true),
        'report_only' => (bool) env('SECURITY_CSP_REPORT_ONLY', false),
        'report_uri' => env('SECURITY_CSP_REPORT_URI', null),
        'directives' => [
            'default-src' => ["'self'"],
            'script-src' => ["'self'"],
            'style-src' => ["'self'"],
            'img-src' => ["'self'"],
            'font-src' => ["'self'"],
            'connect-src' => ["'self'"],
            'media-src' => ["'self'"],
            'object-src' => ["'none'"],
            'frame-src' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Strict Transport Security (HSTS)
    |--------------------------------------------------------------------------
    |
    | HSTS is a security feature that helps protect websites against protocol
    | downgrade attacks and cookie hijacking by telling the browser to only
    | use HTTPS instead of HTTP.
    |
    */
    'hsts' => [
        'enabled' => (bool) env('SECURITY_HSTS_ENABLED', true),
        'max_age' => (int) env('SECURITY_HSTS_MAX_AGE', 31536000), // 1 year
        'include_subdomains' => (bool) env('SECURITY_HSTS_SUBDOMAINS', true),
        'preload' => (bool) env('SECURITY_HSTS_PRELOAD', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS)
    |--------------------------------------------------------------------------
    |
    | CORS is a mechanism that allows restricted resources on a web page to
    | be requested from another domain outside the domain from which the
    | resource originated.
    |
    */
    'cors' => [
        'enabled' => (bool) env('SECURITY_CORS_ENABLED', true),
        'allow_origins' => explode(',', env('SECURITY_CORS_ORIGINS', '*')),
        'allow_methods' => explode(',', env('SECURITY_CORS_METHODS', 'GET,POST,PUT,DELETE,PATCH,OPTIONS')),
        'allow_headers' => explode(',', env('SECURITY_CORS_HEADERS', 'Content-Type,X-Requested-With,Authorization')),
        'expose_headers' => explode(',', env('SECURITY_CORS_EXPOSE', 'Content-Disposition')),
        'allow_credentials' => (bool) env('SECURITY_CORS_CREDENTIALS', false),
        'max_age' => (int) env('SECURITY_CORS_MAX_AGE', 86400), // 24 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting helps protect your application from brute force attacks and
    | prevents overuse of your application's resources.
    |
    */
    'rate_limiting' => [
        'enabled' => (bool) env('SECURITY_RATE_LIMIT_ENABLED', true),
        'identifier' => env('SECURITY_RATE_LIMIT_IDENTIFIER', 'ip'),
        'limit' => (int) env('SECURITY_RATE_LIMIT_LIMIT', 60),
        'duration' => (int) env('SECURITY_RATE_LIMIT_DURATION', 60),
        'status_code' => (int) env('SECURITY_RATE_LIMIT_STATUS', 429),
        'retry_after' => (int) env('SECURITY_RATE_LIMIT_RETRY', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cross-Site Request Forgery (CSRF) Protection
    |--------------------------------------------------------------------------
    |
    | CSRF is a type of attack that occurs when a malicious website, email, or
    | program causes a user's web browser to perform an unwanted action on a
    | site where the user is currently authenticated.
    |
    */
    'csrf' => [
        'enabled' => (bool) env('SECURITY_CSRF_ENABLED', true),
        'token_name' => env('SECURITY_CSRF_TOKEN_NAME', '_csrf_token'),
        'header_name' => env('SECURITY_CSRF_HEADER', 'X-CSRF-TOKEN'),
        'expiration' => (int) env('SECURITY_CSRF_EXPIRATION', 7200), // 2 hours
        'exclude_routes' => explode(',', env('SECURITY_CSRF_EXCLUDE', '/api/*')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Policy
    |--------------------------------------------------------------------------
    |
    | Feature Policy allows web developers to selectively enable, disable, and
    | modify the behavior of certain features and APIs in the browser.
    |
    */
    'feature_policy' => [
        'enabled' => (bool) env('SECURITY_FEATURE_POLICY_ENABLED', true),
        'features' => [
            'camera' => ["'none'"],
            'microphone' => ["'none'"],
            'geolocation' => ["'none'"],
            'accelerometer' => ["'none'"],
            'gyroscope' => ["'none'"],
            'magnetometer' => ["'none'"],
            'payment' => ["'none'"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions Policy
    |--------------------------------------------------------------------------
    |
    | Permissions Policy is a newer replacement for Feature Policy that
    | provides more fine-grained control over browser features.
    |
    */
    'permissions_policy' => [
        'enabled' => (bool) env('SECURITY_PERMISSIONS_POLICY_ENABLED', true),
        'permissions' => [
            'camera' => [],
            'microphone' => [],
            'geolocation' => [],
            'accelerometer' => [],
            'gyroscope' => [],
            'magnetometer' => [],
            'payment' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | When your application is behind a proxy server like Nginx or Apache, some
    | of the request information might be forwarded via HTTP headers. These
    | headers should be trusted to get accurate client information.
    |
    */
    'trusted_proxies' => explode(',', env('SECURITY_TRUSTED_PROXIES', '127.0.0.1')),
    'proxy_headers' => [
        'forwarded' => (bool) env('SECURITY_PROXY_FORWARDED', true),
        'x-forwarded-for' => (bool) env('SECURITY_PROXY_X_FORWARDED_FOR', true),
        'x-forwarded-host' => (bool) env('SECURITY_PROXY_X_FORWARDED_HOST', true),
        'x-forwarded-port' => (bool) env('SECURITY_PROXY_X_FORWARDED_PORT', true),
        'x-forwarded-proto' => (bool) env('SECURITY_PROXY_X_FORWARDED_PROTO', true),
    ],
];
