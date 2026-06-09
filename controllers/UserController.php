<?php

class UserController extends BaseController
{
    public function dashboard(): void
    {
        $this->requireAuth();
        $userId = Session::userId();
        $upcoming = Booking::getUpcoming($userId);
        $recentBookings = Booking::getByUser($userId);
        $notifications = Notification::getByUser($userId, 5);
        $unreadCount = Notification::getUnreadCount($userId);

        view('user.dashboard', compact('upcoming', 'recentBookings', 'notifications', 'unreadCount'), 'user');
    }

    public function bookings(): void
    {
        $this->requireAuth();
        $bookings = Booking::getByUser(Session::userId());
        view('user.bookings', compact('bookings'), 'user');
    }

    public function bookingDetail(string $id): void
    {
        $this->requireAuth();
        $booking = Booking::findById((int) $id);
        if (!$booking || $booking['user_id'] != Session::userId()) {
            Session::flash('error', 'Booking not found.');
            redirect('user/bookings');
        }
        $flights = Booking::getFlights((int) $id);
        $passengers = Passenger::getByBooking((int) $id);
        $payment = Payment::findByBooking((int) $id);
        $tickets = Ticket::getByBooking((int) $id);

        view('user.booking-detail', compact('booking', 'flights', 'passengers', 'payment', 'tickets'), 'user');
    }

    public function profile(): void
    {
        $this->requireAuth();
        $user = User::findById(Session::userId());
        view('user.profile', compact('user'), 'user');
    }

    public function updateProfile(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/profile');
        }
        $this->verifyCsrf();

        $name = Security::sanitize(post('full_name', ''));
        $phone = Security::sanitize(post('phone', ''));
        $data = ['full_name' => $name, 'phone' => $phone];

        if (!empty($_FILES['avatar']['name'])) {
            $avatar = uploadFile($_FILES['avatar'], config('app.upload.avatars_path'), config('app.upload.allowed_images'));
            if ($avatar) {
                $data['avatar'] = $avatar;
            }
        }

        User::update(Session::userId(), $data);
        $_SESSION['user_name'] = $name;
        Session::flash('success', 'Profile updated successfully.');
        redirect('user/profile');
    }

    public function changePassword(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/profile');
        }
        $this->verifyCsrf();

        $user = User::findById(Session::userId());
        $current = post('current_password', '');
        $new = post('new_password', '');
        $confirm = post('confirm_password', '');

        if (!Security::verifyPassword($current, $user['password'])) {
            Session::flash('error', 'Current password is incorrect.');
            redirect('user/profile');
        }
        if (strlen($new) < 8 || $new !== $confirm) {
            Session::flash('error', 'New passwords must match and be at least 8 characters.');
            redirect('user/profile');
        }

        User::update(Session::userId(), ['password' => Security::hashPassword($new)]);
        Session::flash('success', 'Password changed successfully.');
        redirect('user/profile');
    }

    public function notifications(): void
    {
        $this->requireAuth();
        $notifications = Notification::getByUser(Session::userId());
        Notification::markAllAsRead(Session::userId());
        view('user.notifications', compact('notifications'), 'user');
    }

    public function downloadTicket(string $id): void
    {
        $this->requireAuth();
        $ticket = Database::fetch(
            'SELECT t.*, b.user_id, b.cabin_class, b.booking_reference
             FROM tickets t JOIN bookings b ON t.booking_id = b.id WHERE t.id = ?',
            [(int) $id]
        );
        if (!$ticket || $ticket['user_id'] != Session::userId()) {
            redirect('user/bookings');
        }

        $passenger = Passenger::findById($ticket['passenger_id']);
        $flights = Booking::getFlights($ticket['booking_id']);
        $flight = $flights[0] ?? null;
        $booking = Booking::findById($ticket['booking_id']);

        if (!$passenger || !$flight || !$booking) {
            redirect('user/bookings');
        }

        require_once BASE_PATH . '/includes/TicketGenerator.php';
        $filename = TicketGenerator::generate($ticket, $passenger, $flight, $booking);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile(BASE_PATH . '/uploads/tickets/' . $filename);
        exit;
    }

    public function addReview(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/bookings');
        }
        $this->verifyCsrf();

        Review::create([
            'user_id' => Session::userId(),
            'flight_id' => (int) post('flight_id') ?: null,
            'airline_id' => (int) post('airline_id') ?: null,
            'rating' => min(5, max(1, (int) post('rating'))),
            'title' => Security::sanitize(post('title', '')),
            'comment' => Security::sanitize(post('comment', '')),
        ]);

        Session::flash('success', 'Review submitted successfully.');
        redirect('user/bookings');
    }

    public function support(): void
    {
        $this->requireAuth();
        $tickets = SupportTicket::getByUser(Session::userId());
        view('user.support', compact('tickets'), 'user');
    }

    public function createTicket(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/support');
        }
        $this->verifyCsrf();

        $user = User::findById(Session::userId());
        SupportTicket::create([
            'user_id' => Session::userId(),
            'ticket_number' => generateSupportTicketNumber(),
            'name' => $user['full_name'],
            'email' => $user['email'],
            'subject' => Security::sanitize(post('subject', '')),
            'message' => Security::sanitize(post('message', '')),
            'priority' => post('priority', 'medium'),
        ]);

        Session::flash('success', 'Support ticket created successfully.');
        redirect('user/support');
    }
}
