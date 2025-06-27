<?php

return [

    'paths' => [
        'api/*',
        'broadcasting/auth',
        'api/broadcasting/auth',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => [ '*' ],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://192.168.8.145:3000',
        'https://v1-frontend-persp.vercel.app','*',
    ],

    'allowed_origins_patterns' => [
        '^https:\/\/.*\.vercel\.app$',
    ],

    'allowed_headers' => [ '*' ],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
