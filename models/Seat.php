<?php

class Seat
{
    public static function getByFlight(int $flightId, ?string $seatClass = null): array
    {
        $sql = 'SELECT * FROM seats WHERE flight_id = ?';
        $params = [$flightId];
        if ($seatClass) {
            $sql .= ' AND seat_class = ?';
            $params[] = $seatClass;
        }
        return Database::fetchAll($sql . ' ORDER BY seat_number ASC', $params);
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM seats WHERE id = ?', [$id]);
    }

    public static function reserve(int $seatId): bool
    {
        $seat = self::findById($seatId);
        if (!$seat || $seat['status'] !== 'available') {
            return false;
        }
        Database::update('seats', ['status' => 'reserved'], 'id = ?', [$seatId]);
        return true;
    }

    public static function book(int $seatId): void
    {
        Database::update('seats', ['status' => 'booked'], 'id = ?', [$seatId]);
    }

    public static function release(int $seatId): void
    {
        Database::update('seats', ['status' => 'available'], 'id = ?', [$seatId]);
    }

    public static function generateSeatsForFlight(int $flightId, array $counts): void
    {
        $seatNum = 1;
        $classes = [
            'first_class' => $counts['first_class'] ?? 0,
            'business' => $counts['business'] ?? 0,
            'premium_economy' => $counts['premium_economy'] ?? 0,
            'economy' => $counts['economy'] ?? 0,
        ];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach ($classes as $class => $count) {
            for ($i = 0; $i < $count; $i++) {
                $row = intdiv($seatNum - 1, 6) + 1;
                $letter = $letters[($seatNum - 1) % 6];
                Database::insert('seats', [
                    'flight_id' => $flightId,
                    'seat_number' => $row . $letter,
                    'seat_class' => $class,
                    'status' => 'available',
                ]);
                $seatNum++;
            }
        }
    }

    public static function getSeatMap(int $flightId): array
    {
        $seats = self::getByFlight($flightId);
        $map = [];
        foreach ($seats as $seat) {
            $map[$seat['seat_class']][] = $seat;
        }
        return $map;
    }
}
