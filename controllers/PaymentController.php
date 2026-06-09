<?php

class PaymentController extends BaseController
{
    public function show(string $id): void
    {
        $this->requireAuth();
        $booking = Booking::findById((int) $id);
        if (!$booking || $booking['user_id'] != Session::userId()) {
            Session::flash('error', 'Booking not found.');
            redirect('user/bookings');
        }
        if ($booking['status'] !== 'pending') {
            Session::flash('info', 'This booking has already been processed.');
            redirect("user/bookings/{$id}");
        }

        $payment = Payment::findByBooking((int) $id);
        view('payment.index', compact('booking', 'payment'));
    }

    public function process(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/bookings');
        }
        $this->verifyCsrf();

        $bookingId = (int) post('booking_id');
        $method = post('payment_method', 'bank_transfer');
        $booking = Booking::findById($bookingId);

        if (!$booking || $booking['user_id'] != Session::userId()) {
            Session::flash('error', 'Invalid booking.');
            redirect('user/bookings');
        }

        $transactionId = strtoupper($method) . '-' . time() . '-' . random_int(1000, 9999);
        $status = match ($method) {
            'stripe', 'paypal' => 'paid',
            'bank_transfer', 'manual' => 'pending',
            default => 'pending',
        };

        $paymentId = Payment::create([
            'booking_id' => $bookingId,
            'payment_method' => $method,
            'transaction_id' => $transactionId,
            'amount' => $booking['final_amount'],
            'currency' => 'USD',
            'status' => $status,
            'paid_at' => $status === 'paid' ? date('Y-m-d H:i:s') : null,
        ]);

        if ($status === 'paid') {
            $this->confirmBooking($booking, $paymentId);
            Session::flash('success', 'Payment successful! Your booking is confirmed.');
            redirect("user/bookings/{$bookingId}");
        }

        Session::flash('success', 'Payment submitted. Awaiting confirmation.');
        redirect("user/bookings/{$bookingId}");
    }

    public function approve(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) {
            redirect('admin/payments');
        }
        $this->verifyCsrf();

        $payment = Database::fetch('SELECT * FROM payments WHERE id = ?', [(int) $id]);
        if (!$payment) {
            redirect('admin/payments');
        }

        Payment::update((int) $id, [
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s'),
        ]);

        $booking = Booking::findById($payment['booking_id']);
        $this->confirmBooking($booking, (int) $id);

        Session::flash('success', 'Payment approved and booking confirmed.');
        redirect('admin/payments');
    }

    private function confirmBooking(array $booking, int $paymentId): void
    {
        Booking::update($booking['id'], ['status' => 'confirmed']);
        $passengers = Passenger::getByBooking($booking['id']);
        foreach ($passengers as $p) {
            if ($p['seat_id']) {
                Seat::book((int) $p['seat_id']);
            }
        }
        Ticket::generateForBooking($booking['id']);

        $user = User::findById($booking['user_id']);
        $payment = Database::fetch('SELECT * FROM payments WHERE id = ?', [$paymentId]);

        Mailer::sendBookingConfirmation($user['email'], $user['full_name'], $booking);
        if ($payment) {
            Mailer::sendPaymentConfirmation($user['email'], $user['full_name'], $payment);
        }
        Notification::create($booking['user_id'], 'payment', 'Booking Confirmed', "Your booking {$booking['booking_reference']} is confirmed!", url("user/bookings/{$booking['id']}"));
    }
}
