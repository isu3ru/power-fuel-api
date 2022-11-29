<?php

return [
    'version' => env('SYSTEM_VERSION', '0.1'),
    'title' => env('SYSTEM_TITLE', 'Power Fuel API'),
    'short_title' => env('SYSTEM_SHORT_TITLE', 'Power Fuel API'),
    'description' => env('SYSTEM_DESCRIPTION', 'Power Fuel API'),
    'developer' => [
        'company' => 'Collaborators',
        'authors' => [
            [
                'name' => 'Isuru Ranawaka',
                'email' => 'isuru@mybooking.lk',
            ],
        ],
    ],
    'google' => [
        'maps' => [
            'api_key' => env('GOOGLE_MAPS_API_KEY', ''),
        ],
    ],
];
