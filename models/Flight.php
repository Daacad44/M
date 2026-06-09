<?php

class Flight
{
    public static function findById(int $id): ?array
    {
        return Database::fetch(
            "SELECT f.*, al.name as airline_name, al.code as airline_code, al.logo as airline_logo,
                    da.name as departure_airport, da.code as departure_code, da.city as departure_city,
                    aa.name as arrival_airport, aa.code as arrival_code, aa.city as arrival_city
             FROM flights f
             JOIN airlines al ON f.airline_id = al.id
             JOIN airports da ON f.departure_airport_id = da.id
             JOIN airports aa ON f.arrival_airport_id = aa.id
             WHERE f.id = ?",
            [$id]
        );
    }

    public static function search(array $filters): array
    {
        $sql = "SELECT f.*, al.name as airline_name, al.code as airline_code, al.logo as airline_logo,
                       da.name as departure_airport, da.code as departure_code, da.city as departure_city,
                       aa.name as arrival_airport, aa.code as arrival_code, aa.city as arrival_city
                FROM flights f
                JOIN airlines al ON f.airline_id = al.id
                JOIN airports da ON f.departure_airport_id = da.id
                JOIN airports aa ON f.arrival_airport_id = aa.id
                WHERE f.status = 'scheduled' AND f.departure_time > NOW()";
        $params = [];

        if (!empty($filters['from'])) {
            $sql .= ' AND f.departure_airport_id = ?';
            $params[] = $filters['from'];
        }
        if (!empty($filters['to'])) {
            $sql .= ' AND f.arrival_airport_id = ?';
            $params[] = $filters['to'];
        }
        if (!empty($filters['departure_date'])) {
            $sql .= ' AND DATE(f.departure_time) = ?';
            $params[] = $filters['departure_date'];
        }
        if (!empty($filters['airline'])) {
            $sql .= ' AND f.airline_id = ?';
            $params[] = $filters['airline'];
        }
        if (isset($filters['stops']) && $filters['stops'] !== '') {
            $sql .= ' AND f.stops = ?';
            $params[] = $filters['stops'];
        }
        if (!empty($filters['min_price'])) {
            $class = $filters['cabin_class'] ?? 'economy';
            $priceCol = self::priceColumn($class);
            $sql .= " AND f.{$priceCol} >= ?";
            $params[] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $class = $filters['cabin_class'] ?? 'economy';
            $priceCol = self::priceColumn($class);
            $sql .= " AND f.{$priceCol} <= ?";
            $params[] = $filters['max_price'];
        }
        if (!empty($filters['departure_time'])) {
            $hour = match ($filters['departure_time']) {
                'morning' => [5, 12],
                'afternoon' => [12, 17],
                'evening' => [17, 21],
                'night' => [21, 5],
                default => null,
            };
            if ($hour) {
                if ($filters['departure_time'] === 'night') {
                    $sql .= ' AND (HOUR(f.departure_time) >= 21 OR HOUR(f.departure_time) < 5)';
                } else {
                    $sql .= ' AND HOUR(f.departure_time) >= ? AND HOUR(f.departure_time) < ?';
                    $params = array_merge($params, $hour);
                }
            }
        }

        $class = $filters['cabin_class'] ?? 'economy';
        $priceCol = self::priceColumn($class);
        $sort = $filters['sort'] ?? 'price_asc';
        $sql .= match ($sort) {
            'price_desc' => " ORDER BY f.{$priceCol} DESC",
            'duration_asc' => ' ORDER BY f.duration_minutes ASC',
            'duration_desc' => ' ORDER BY f.duration_minutes DESC',
            'departure_asc' => ' ORDER BY f.departure_time ASC',
            default => " ORDER BY f.{$priceCol} ASC",
        };

        return Database::fetchAll($sql, $params);
    }

    public static function priceColumn(string $cabinClass): string
    {
        return match ($cabinClass) {
            'premium_economy' => 'premium_economy_price',
            'business' => 'business_price',
            'first_class' => 'first_class_price',
            default => 'economy_price',
        };
    }

    public static function getPrice(array $flight, string $cabinClass): float
    {
        $col = self::priceColumn($cabinClass);
        return (float) ($flight[$col] ?? $flight['economy_price']);
    }

    public static function getAvailableSeats(int $flightId, string $cabinClass): int
    {
        $col = match ($cabinClass) {
            'premium_economy' => 'premium_economy_seats',
            'business' => 'business_seats',
            'first_class' => 'first_class_seats',
            default => 'economy_seats',
        };
        $flight = Database::fetch("SELECT {$col} as seats FROM flights WHERE id = ?", [$flightId]);
        return (int) ($flight['seats'] ?? 0);
    }

    public static function create(array $data): int
    {
        return Database::insert('flights', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('flights', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('flights', 'id = ?', [$id]);
    }

    public static function countAll(): int
    {
        return Database::count('flights');
    }

    public static function getAll(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        return Database::fetchAll(
            "SELECT f.*, al.name as airline_name, da.code as departure_code, aa.code as arrival_code
             FROM flights f
             JOIN airlines al ON f.airline_id = al.id
             JOIN airports da ON f.departure_airport_id = da.id
             JOIN airports aa ON f.arrival_airport_id = aa.id
             ORDER BY f.departure_time DESC LIMIT ? OFFSET ?",
            [$perPage, $offset]
        );
    }

    public static function getPopularDestinations(int $limit = 5): array
    {
        return Database::fetchAll(
            "SELECT aa.city, aa.country, aa.code, COUNT(bf.id) as booking_count
             FROM booking_flights bf
             JOIN flights f ON bf.flight_id = f.id
             JOIN airports aa ON f.arrival_airport_id = aa.id
             GROUP BY aa.id
             ORDER BY booking_count DESC
             LIMIT ?",
            [$limit]
        );
    }
}
