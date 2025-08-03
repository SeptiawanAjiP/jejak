<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Jejak Tracking Enabled
    |--------------------------------------------------------------------------
    |
    | Set to false to disable tracking completely
    | Note: You still need to add 'jejak' middleware to routes you want to track
    |
    */
    'enabled' => env('JEJAK_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Skip AJAX Requests
    |--------------------------------------------------------------------------
    |
    | Whether to skip tracking AJAX requests
    |
    */
    'skip_ajax' => env('JEJAK_SKIP_AJAX', false),

    /*
    |--------------------------------------------------------------------------
    | Skip Routes
    |--------------------------------------------------------------------------
    |
    | Routes that should not be tracked (even if middleware is applied)
    |
    */
    'skip_routes' => [
        'api/*',
        'admin/api/*',
        '_debugbar/*',
        'telescope/*',
        'horizon/*',
        'jejak/*', // Skip jejak dashboard routes
    ],

    /*
    |--------------------------------------------------------------------------
    | Skip IPs
    |--------------------------------------------------------------------------
    |
    | IP addresses that should not be tracked
    |
    */
    'skip_ips' => [
        '127.0.0.1',
        '::1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skip Bots
    |--------------------------------------------------------------------------
    |
    | User agents that should not be tracked
    |
    */
    'skip_bots' => [
        'bot',
        'crawler',
        'spider',
        'scraper',
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Errors
    |--------------------------------------------------------------------------
    |
    | Whether to log tracking errors
    |
    */
    'log_errors' => env('JEJAK_LOG_ERRORS', true),

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for jejak dashboard routes
    |
    */
    'route' => [
        'prefix' => 'jejak',
        'middleware' => ['web', 'auth'],
        'name' => 'jejak.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Configuration
    |--------------------------------------------------------------------------
    |
    | Automatic cleanup of old jejak data
    |
    */
    'cleanup' => [
        'enabled' => true,
        'days' => 90, // Keep data for 90 days
    ],
];