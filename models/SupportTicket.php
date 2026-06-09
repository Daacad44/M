<?php

class SupportTicket
{
    public static function create(array $data): int
    {
        return Database::insert('support_tickets', $data);
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM support_tickets WHERE id = ?', [$id]);
    }

    public static function getByUser(int $userId): array
    {
        return Database::fetchAll(
            'SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC',
            [$userId]
        );
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT st.*, u.full_name as user_name FROM support_tickets st
             LEFT JOIN users u ON st.user_id = u.id
             ORDER BY st.created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('support_tickets', $data, 'id = ?', [$id]);
    }

    public static function countOpen(): int
    {
        return Database::count('support_tickets', "status IN ('open','in_progress')");
    }
}
