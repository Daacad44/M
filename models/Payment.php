<?php

class Payment
{
    public static function create(array $data): int
    {
        return Database::insert('payments', $data);
    }

    public static function findByBooking(int $bookingId): ?array
    {
        return Database::fetch('SELECT * FROM payments WHERE booking_id = ? ORDER BY created_at DESC LIMIT 1', [$bookingId]);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('payments', $data, 'id = ?', [$id]);
    }

    public static function countPending(): int
    {
        return Database::count('payments', "status = 'pending'");
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT p.*, b.booking_reference, u.full_name as user_name
             FROM payments p
             JOIN bookings b ON p.booking_id = b.id
             JOIN users u ON b.user_id = u.id
             ORDER BY p.created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }

    public static function getTotalPaid(): float
    {
        $result = Database::fetch("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'paid'");
        return (float) ($result['total'] ?? 0);
    }
}
