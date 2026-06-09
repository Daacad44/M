<?php

class Notification
{
    public static function create(int $userId, string $type, string $title, string $message, ?string $link = null): int
    {
        return Database::insert('notifications', [
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    public static function getByUser(int $userId, int $limit = 20): array
    {
        return Database::fetchAll(
            'SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?',
            [$userId, $limit]
        );
    }

    public static function getUnreadCount(int $userId): int
    {
        return Database::count('notifications', 'user_id = ? AND is_read = 0', [$userId]);
    }

    public static function markAsRead(int $id, int $userId): void
    {
        Database::update('notifications', ['is_read' => 1], 'id = ? AND user_id = ?', [$id, $userId]);
    }

    public static function markAllAsRead(int $userId): void
    {
        Database::update('notifications', ['is_read' => 1], 'user_id = ?', [$userId]);
    }
}
