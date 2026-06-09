<?php

return [
    'name' => 'FLYHUB',
    'tagline' => 'Fly Easy, Book Smart',
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'timezone' => 'UTC',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'version' => '1.0.0',

    'session' => [
        'name' => 'SKYWINGS_SESSION',
        'lifetime' => 7200,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ],

    'upload' => [
        'max_size' => 2097152,
        'allowed_images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'airlines_path' => 'uploads/airlines/',
        'avatars_path' => 'uploads/avatars/',
        'tickets_path' => 'uploads/tickets/',
    ],

    'pagination' => [
        'per_page' => 10,
        'admin_per_page' => 15,
    ],

    'rate_limit' => [
        'login' => ['max' => 5, 'window' => 900],
        'register' => ['max' => 3, 'window' => 3600],
        'contact' => ['max' => 5, 'window' => 3600],
    ],

    'booking' => [
        'reference_prefix' => 'SW',
        'ticket_prefix' => 'TKT',
    ],
];
