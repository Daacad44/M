<?php

class Passenger
{
    public static function create(array $data): int
    {
        return Database::insert('passengers', $data);
    }

    public static function getByBooking(int $bookingId): array
    {
        return Database::fetchAll(
            'SELECT p.*, s.seat_number FROM passengers p
             LEFT JOIN seats s ON p.seat_id = s.id
             WHERE p.booking_id = ? ORDER BY p.id ASC',
            [$bookingId]
        );
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM passengers WHERE id = ?', [$id]);
    }

    public static function countAll(): int
    {
        return Database::count('passengers');
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT p.*, b.booking_reference FROM passengers p
             JOIN bookings b ON p.booking_id = b.id
             ORDER BY p.created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }
}
