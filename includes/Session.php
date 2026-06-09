<?php

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        $config = require BASE_PATH . '/config/app.php';
        $session = $config['session'];

        session_name($session['name']);
        session_set_cookie_params([
            'lifetime' => $session['lifetime'],
            'path' => '/',
            'secure' => $session['secure'],
            'httponly' => $session['httponly'],
            'samesite' => $session['samesite'],
        ]);
        session_start();

        if (empty($_SESSION['initiated'])) {
            session_regenerate_id(true);
            $_SESSION['initiated'] = true;
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        $val = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }

    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function login(array $user, bool $remember = false): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        if ($remember) {
            $token = Security::generateToken();
            Database::update('users', ['remember_token' => $token], 'id = ?', [$user['id']]);
            setcookie('remember_token', $token, time() + 2592000, '/', '', false, true);
            setcookie('remember_user', (string) $user['id'], time() + 2592000, '/', '', false, true);
        }
    }

    public static function logout(): void
    {
        if ($userId = self::userId()) {
            Database::update('users', ['remember_token' => null], 'id = ?', [$userId]);
        }
        setcookie('remember_token', '', time() - 3600, '/');
        setcookie('remember_user', '', time() - 3600, '/');
        self::destroy();
    }

    public static function checkRememberMe(): void
    {
        if (self::isLoggedIn()) {
            return;
        }
        $userId = $_COOKIE['remember_user'] ?? null;
        $token = $_COOKIE['remember_token'] ?? null;
        if ($userId && $token) {
            $user = Database::fetch(
                'SELECT * FROM users WHERE id = ? AND remember_token = ? AND status = ?',
                [$userId, $token, 'active']
            );
            if ($user) {
                self::login($user);
            }
        }
    }
}
