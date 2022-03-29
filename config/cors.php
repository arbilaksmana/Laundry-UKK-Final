<?php

// header('Access-Control-Allow-Origin:  http://127.0.0.1:8000');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
// header('Access-Control-Allow-Methods:  POST, PUT');

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

<<<<<<< HEAD
=======
    // 'paths' => ['api/*', 'sanctum/csrf-cookie'],

>>>>>>> 86174792523889bc51d0dd98860dc0eb34db59a0
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // 'allowed_origins' => ['http://localhost:8081'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
