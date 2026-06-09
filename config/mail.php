<?php

return [
    'from_email' => getenv('MAIL_FROM') ?: 'noreply@skywings.com',
    'from_name' => getenv('MAIL_FROM_NAME') ?: 'SkyWings',
    'smtp' => [
        'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
        'port' => (int)(getenv('SMTP_PORT') ?: 587),
        'username' => getenv('SMTP_USER') ?: '',
        'password' => getenv('SMTP_PASS') ?: '',
        'encryption' => getenv('SMTP_ENCRYPTION') ?: 'tls',
    ],
];
