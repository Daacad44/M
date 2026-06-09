<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/includes/Database.php';
require_once BASE_PATH . '/includes/Security.php';
require_once BASE_PATH . '/includes/Session.php';
require_once BASE_PATH . '/includes/helpers.php';

$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value, " \t\n\r\0\x0B\"'"));
    }
}

date_default_timezone_set(config('app.timezone', 'UTC'));

if (config('app.debug')) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

Session::start();
Session::checkRememberMe();

spl_autoload_register(function (string $class) {
    $paths = [
        BASE_PATH . '/models/' . $class . '.php',
        BASE_PATH . '/controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once BASE_PATH . '/includes/Router.php';
