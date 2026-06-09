<?php

class Security
{
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = self::generateToken();
        }
        return $_SESSION['csrf_token'];
    }

    public static function csrfField(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . self::escape(self::csrfToken()) . '">';
    }

    public static function verifyCsrf(?string $token): bool
    {
        return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function escape(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    public static function sanitize(string $value): string
    {
        return trim(strip_tags($value));
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function checkRateLimit(string $action, int $maxAttempts, int $windowSeconds): bool
    {
        $ip = self::getClientIp();
        $row = Database::fetch(
            'SELECT * FROM rate_limits WHERE ip_address = ? AND action = ?',
            [$ip, $action]
        );

        if ($row) {
            $lastAttempt = strtotime($row['last_attempt']);
            if (time() - $lastAttempt > $windowSeconds) {
                Database::update('rate_limits', ['attempts' => 1, 'last_attempt' => date('Y-m-d H:i:s')], 'id = ?', [$row['id']]);
                return true;
            }
            if ($row['attempts'] >= $maxAttempts) {
                return false;
            }
            Database::update('rate_limits', [
                'attempts' => $row['attempts'] + 1,
                'last_attempt' => date('Y-m-d H:i:s'),
            ], 'id = ?', [$row['id']]);
            return true;
        }

        Database::insert('rate_limits', [
            'ip_address' => $ip,
            'action' => $action,
            'attempts' => 1,
            'last_attempt' => date('Y-m-d H:i:s'),
        ]);
        return true;
    }

    public static function resetRateLimit(string $action): void
    {
        Database::delete('rate_limits', 'ip_address = ? AND action = ?', [self::getClientIp(), $action]);
    }

    public static function getClientIp(): string
    {
        $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = explode(',', $_SERVER[$key])[0];
                return trim($ip);
            }
        }
        return '0.0.0.0';
    }
}
