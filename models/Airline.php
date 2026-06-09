<?php

class Airline
{
    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM airlines WHERE id = ?', [$id]);
    }

    public static function getAll(bool $activeOnly = false): array
    {
        $sql = 'SELECT * FROM airlines';
        if ($activeOnly) {
            $sql .= " WHERE status = 'active'";
        }
        return Database::fetchAll($sql . ' ORDER BY name ASC');
    }

    public static function create(array $data): int
    {
        return Database::insert('airlines', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('airlines', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('airlines', 'id = ?', [$id]);
    }

    public static function countAll(): int
    {
        return Database::count('airlines');
    }
}
