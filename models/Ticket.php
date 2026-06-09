<?php

class Ticket
{
    public static function create(array $data): int
    {
        return Database::insert('tickets', $data);
    }

    public static function getByBooking(int $bookingId): array
    {
        return Database::fetchAll(
            'SELECT t.*, p.first_name, p.last_name, p.passenger_type
             FROM tickets t JOIN passengers p ON t.passenger_id = p.id
             WHERE t.booking_id = ?',
            [$bookingId]
        );
    }

    public static function findByNumber(string $number): ?array
    {
        return Database::fetch('SELECT * FROM tickets WHERE ticket_number = ?', [$number]);
    }

    public static function generateForBooking(int $bookingId): void
    {
        $passengers = Passenger::getByBooking($bookingId);
        foreach ($passengers as $passenger) {
            $ticketNumber = generateTicketNumber();
            Database::insert('tickets', [
                'booking_id' => $bookingId,
                'passenger_id' => $passenger['id'],
                'ticket_number' => $ticketNumber,
                'qr_code' => $ticketNumber,
                'seat_number' => $passenger['seat_number'] ?? null,
                'status' => 'active',
            ]);
        }
    }
}
