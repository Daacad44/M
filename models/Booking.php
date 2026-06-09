<?php

class Booking
{
    public static function findById(int $id): ?array
    {
        return Database::fetch(
            'SELECT b.*, u.full_name as user_name, u.email as user_email
             FROM bookings b JOIN users u ON b.user_id = u.id WHERE b.id = ?',
            [$id]
        );
    }

    public static function findByReference(string $ref): ?array
    {
        return Database::fetch('SELECT * FROM bookings WHERE booking_reference = ?', [$ref]);
    }

    public static function create(array $data): int
    {
        return Database::insert('bookings', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('bookings', $data, 'id = ?', [$id]);
    }

    public static function addFlight(int $bookingId, int $flightId, int $legOrder, float $price): int
    {
        return Database::insert('booking_flights', [
            'booking_id' => $bookingId,
            'flight_id' => $flightId,
            'leg_order' => $legOrder,
            'price' => $price,
        ]);
    }

    public static function getFlights(int $bookingId): array
    {
        return Database::fetchAll(
            "SELECT bf.*, f.*, al.name as airline_name, al.code as airline_code,
                    da.name as departure_airport, da.code as departure_code,
                    aa.name as arrival_airport, aa.code as arrival_code
             FROM booking_flights bf
             JOIN flights f ON bf.flight_id = f.id
             JOIN airlines al ON f.airline_id = al.id
             JOIN airports da ON f.departure_airport_id = da.id
             JOIN airports aa ON f.arrival_airport_id = aa.id
             WHERE bf.booking_id = ?
             ORDER BY bf.leg_order ASC",
            [$bookingId]
        );
    }

    public static function getByUser(int $userId, ?string $status = null): array
    {
        $sql = 'SELECT * FROM bookings WHERE user_id = ?';
        $params = [$userId];
        if ($status) {
            $sql .= ' AND status = ?';
            $params[] = $status;
        }
        return Database::fetchAll($sql . ' ORDER BY created_at DESC', $params);
    }

    public static function getUpcoming(int $userId): array
    {
        return Database::fetchAll(
            "SELECT b.* FROM bookings b
             JOIN booking_flights bf ON b.id = bf.booking_id
             JOIN flights f ON bf.flight_id = f.id
             WHERE b.user_id = ? AND b.status IN ('confirmed','pending') AND f.departure_time > NOW()
             GROUP BY b.id ORDER BY f.departure_time ASC",
            [$userId]
        );
    }

    public static function countAll(): int
    {
        return Database::count('bookings');
    }

    public static function countByStatus(string $status): int
    {
        return Database::count('bookings', 'status = ?', [$status]);
    }

    public static function getTotalRevenue(): float
    {
        $result = Database::fetch(
            "SELECT COALESCE(SUM(final_amount), 0) as total FROM bookings WHERE status IN ('confirmed','completed')"
        );
        return (float) ($result['total'] ?? 0);
    }

    public static function getMonthlyRevenue(): array
    {
        return Database::fetchAll(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(final_amount) as revenue, COUNT(*) as bookings
             FROM bookings WHERE status IN ('confirmed','completed')
             GROUP BY month ORDER BY month DESC LIMIT 12"
        );
    }

    public static function getBookingTrends(): array
    {
        return Database::fetchAll(
            "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(*) as count
             FROM bookings WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY date ORDER BY date ASC"
        );
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            'SELECT b.*, u.full_name as user_name FROM bookings b
             JOIN users u ON b.user_id = u.id
             ORDER BY b.created_at DESC LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );
    }
}
