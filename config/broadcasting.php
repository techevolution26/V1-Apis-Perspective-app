<?php

return [
    'default' => 'pusher',
    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER', 'eu'),  // Default to 'eu' for Kenya
                'useTLS' => true,
                'encrypted' => true,
                'host' => env('PUSHER_HOST', 'localhost'),  // Explicit EU endpoint
                'port' => env('PUSHER_PORT', 6001),
                'scheme' => 'https',
                'auth' => [
                    'headers' => [
                        'Authorization' => isset($_SERVER['HTTP_AUTHORIZATION']) ? 'Bearer ' . $_SERVER['HTTP_AUTHORIZATION'] : null,
                    ],
                ],
                'curl_options' => [
                    CURLOPT_SSL_VERIFYHOST => 2,  // Enhanced security
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_CONNECTTIMEOUT => 10,  // Timeout tweak for African networks
                ],
            ],
        ],
        // Other drivers (keep as fallback)
        'redis' => [/* ... */],
        'log' => [/* ... */],
        'null' => [/* ... */],
    ],
];
