<?php

class User
{
    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM users WHERE id = ?', [$id]);
    }

    public static function findByEmail(string $email): ?array
    {
        return Database::fetch('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public static function create(array $data): int
    {
        return Database::insert('users', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('users', $data, 'id = ?', [$id]);
    }

    public static function countAll(): int
    {
        return Database::count('users');
    }

    public static function countByMonth(): array
    {
        return Database::fetchAll(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
             FROM users WHERE role = 'user'
             GROUP BY month ORDER BY month DESC LIMIT 12"
        );
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }

    public static function search(string $query, int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        $like = "%{$query}%";
        return Database::fetchAll(
            'SELECT * FROM users WHERE full_name LIKE ? OR email LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?',
            [$like, $like, $perPage, $offset]
        );
    }
}
