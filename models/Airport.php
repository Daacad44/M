<?php

class Airport
{
    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM airports WHERE id = ?', [$id]);
    }

    public static function findByCode(string $code): ?array
    {
        return Database::fetch('SELECT * FROM airports WHERE code = ?', [$code]);
    }

    public static function getAll(bool $activeOnly = false): array
    {
        $sql = 'SELECT * FROM airports';
        if ($activeOnly) {
            $sql .= " WHERE status = 'active'";
        }
        return Database::fetchAll($sql . ' ORDER BY city ASC');
    }

    public static function search(string $query): array
    {
        $like = "%{$query}%";
        return Database::fetchAll(
            "SELECT * FROM airports WHERE status = 'active' AND (name LIKE ? OR code LIKE ? OR city LIKE ? OR country LIKE ?) ORDER BY city ASC LIMIT 20",
            [$like, $like, $like, $like]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert('airports', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('airports', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('airports', 'id = ?', [$id]);
    }

    public static function countAll(): int
    {
        return Database::count('airports');
    }

    public static function getPopular(int $limit = 6): array
    {
        return Database::fetchAll(
            "SELECT a.*, COUNT(f.id) as flight_count
             FROM airports a
             LEFT JOIN flights f ON f.departure_airport_id = a.id OR f.arrival_airport_id = a.id
             WHERE a.status = 'active'
             GROUP BY a.id
             ORDER BY flight_count DESC
             LIMIT ?",
            [$limit]
        );
    }
}
