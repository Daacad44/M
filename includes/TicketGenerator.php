<?php

require_once BASE_PATH . '/includes/lib/fpdf/fpdf.php';

class TicketGenerator
{
    public static function generate(array $ticket, array $passenger, array $flight, array $booking): string
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(13, 110, 253);
        $pdf->Cell(0, 15, config('app.name', 'SkyWings') . ' - E-Ticket', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 8, 'Booking Reference: ' . $booking['booking_reference'], 0, 1);
        $pdf->Cell(0, 8, 'Ticket Number: ' . $ticket['ticket_number'], 0, 1);
        $pdf->Ln(5);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, 'Passenger Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 7, 'Name: ' . $passenger['first_name'] . ' ' . $passenger['last_name'], 0, 1);
        $pdf->Cell(0, 7, 'Type: ' . ucfirst($passenger['passenger_type']), 0, 1);
        $pdf->Cell(0, 7, 'Passport: ' . ($passenger['passport_number'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 7, 'Seat: ' . ($ticket['seat_number'] ?? 'To be assigned'), 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, 'Flight Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 7, 'Flight: ' . $flight['flight_number'] . ' - ' . $flight['airline_name'], 0, 1);
        $pdf->Cell(0, 7, 'Aircraft: ' . ($flight['aircraft_type'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 7, 'From: ' . $flight['departure_airport'] . ' (' . $flight['departure_code'] . ')', 0, 1);
        $pdf->Cell(0, 7, 'To: ' . $flight['arrival_airport'] . ' (' . $flight['arrival_code'] . ')', 0, 1);
        $pdf->Cell(0, 7, 'Departure: ' . formatDateTime($flight['departure_time']), 0, 1);
        $pdf->Cell(0, 7, 'Arrival: ' . formatDateTime($flight['arrival_time']), 0, 1);
        $pdf->Cell(0, 7, 'Duration: ' . formatDuration((int) $flight['duration_minutes']), 0, 1);
        $pdf->Cell(0, 7, 'Class: ' . cabinClassLabel($booking['cabin_class']), 0, 1);
        $pdf->Ln(10);

        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($ticket['ticket_number']);
        $qrPath = BASE_PATH . '/uploads/tickets/qr_' . $ticket['ticket_number'] . '.png';
        if (!file_exists($qrPath)) {
            $qrData = @file_get_contents($qrUrl);
            if ($qrData) {
                file_put_contents($qrPath, $qrData);
            }
        }
        if (file_exists($qrPath)) {
            $pdf->Image($qrPath, 85, $pdf->GetY(), 40, 40);
            $pdf->Ln(45);
        }

        $pdf->SetFont('Arial', 'I', 9);
        $pdf->SetTextColor(128, 128, 128);
        $pdf->Cell(0, 5, 'Please arrive at the airport at least 2 hours before departure.', 0, 1, 'C');
        $pdf->Cell(0, 5, 'This is an electronic ticket. No paper ticket required.', 0, 1, 'C');

        $filename = 'ticket_' . $ticket['ticket_number'] . '.pdf';
        $filepath = BASE_PATH . '/uploads/tickets/' . $filename;
        $pdf->Output('F', $filepath);
        return $filename;
    }
}
