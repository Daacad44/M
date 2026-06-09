<?php

class Review
{
    public static function create(array $data): int
    {
        return Database::insert('reviews', $data);
    }

    public static function getByAirline(int $airlineId): array
    {
        return Database::fetchAll(
            "SELECT r.*, u.full_name as user_name FROM reviews r
             JOIN users u ON r.user_id = u.id
             WHERE r.airline_id = ? AND r.status = 'approved' ORDER BY r.created_at DESC",
            [$airlineId]
        );
    }

    public static function getAverageRating(?int $airlineId = null): float
    {
        $sql = "SELECT AVG(rating) as avg_rating FROM reviews WHERE status = 'approved'";
        $params = [];
        if ($airlineId) {
            $sql .= ' AND airline_id = ?';
            $params[] = $airlineId;
        }
        $result = Database::fetch($sql, $params);
        return round((float) ($result['avg_rating'] ?? 0), 1);
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT r.*, u.full_name as user_name, al.name as airline_name
             FROM reviews r
             JOIN users u ON r.user_id = u.id
             LEFT JOIN airlines al ON r.airline_id = al.id
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('reviews', $data, 'id = ?', [$id]);
    }
}
