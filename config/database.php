<?php

return [
    'host' => 'sql111.infinityfree.com',
    'port' => '3306',
    'database' => 'if0_42142313_flight_bookingss',
    'username' => 'if0_42142313',
    'password' => 'flyhub1234',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
