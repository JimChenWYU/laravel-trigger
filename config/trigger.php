<?php

return [
    'default' => 'default',

    'replications' => [
        'default' => [
            'host'      => env('TRIGGER_HOST', ''),
            'port'      => env('TRIGGER_PORT', 3306),
            'user'      => env('TRIGGER_USER', ''),
            'password'  => env('TRIGGER_PASSWORD', ''),

            // detect from trigger routers
            'detect'    => (bool)env('TRIGGER_DETECT', false),
            // or set database and tables
            'databases' => env('TRIGGER_DATABASES', '') ? explode(',', env('TRIGGER_DATABASES')) : [],
            'tables'    => env('TRIGGER_TABLES', '') ? explode(',', env('TRIGGER_TABLES')) : [],

            'heartbeat'   => (int)env('TRIGGER_HEARTBEAT', 3),
            'subscribers' => [
                 // JimChen\Trigger\Subscribers\Heartbeat::class,
            ],
            'route'       => app()->basePath('routes/trigger.php'),
        ],
    ],
];
