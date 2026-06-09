<?php

class AdminController extends BaseController
{
    public function dashboard(): void
    {
        $this->requireAdmin();
        $stats = [
            'users' => User::countAll(),
            'flights' => Flight::countAll(),
            'bookings' => Booking::countAll(),
            'revenue' => Booking::getTotalRevenue(),
            'pending_payments' => Payment::countPending(),
            'open_tickets' => SupportTicket::countOpen(),
        ];
        $monthlyRevenue = Booking::getMonthlyRevenue();
        $bookingTrends = Booking::getBookingTrends();
        $userRegistrations = User::countByMonth();
        $popularDestinations = Flight::getPopularDestinations(5);
        $recentBookings = Booking::getAll(1, 5);

        view('admin.dashboard', compact('stats', 'monthlyRevenue', 'bookingTrends', 'userRegistrations', 'popularDestinations', 'recentBookings'), 'admin');
    }

    // Flights
    public function flights(): void
    {
        $this->requireAdmin();
        $flights = Flight::getAll();
        view('admin.flights.index', compact('flights'), 'admin');
    }

    public function flightCreate(): void
    {
        $this->requireAdmin();
        $airlines = Airline::getAll(true);
        $airports = Airport::getAll(true);
        view('admin.flights.create', compact('airlines', 'airports'), 'admin');
    }

    public function flightStore(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/flights');
        $this->verifyCsrf();

        $dep = post('departure_time');
        $arr = post('arrival_time');
        $duration = (int) ((strtotime($arr) - strtotime($dep)) / 60);

        $data = [
            'flight_number' => Security::sanitize(post('flight_number')),
            'airline_id' => (int) post('airline_id'),
            'aircraft_type' => Security::sanitize(post('aircraft_type')),
            'departure_airport_id' => (int) post('departure_airport_id'),
            'arrival_airport_id' => (int) post('arrival_airport_id'),
            'departure_time' => $dep,
            'arrival_time' => $arr,
            'duration_minutes' => max(0, $duration),
            'stops' => (int) post('stops', 0),
            'economy_price' => (float) post('economy_price'),
            'premium_economy_price' => (float) post('premium_economy_price'),
            'business_price' => (float) post('business_price'),
            'first_class_price' => (float) post('first_class_price'),
            'economy_seats' => (int) post('economy_seats', 0),
            'premium_economy_seats' => (int) post('premium_economy_seats', 0),
            'business_seats' => (int) post('business_seats', 0),
            'first_class_seats' => (int) post('first_class_seats', 0),
            'status' => post('status', 'scheduled'),
        ];

        $flightId = Flight::create($data);
        Seat::generateSeatsForFlight($flightId, [
            'economy' => $data['economy_seats'],
            'premium_economy' => $data['premium_economy_seats'],
            'business' => $data['business_seats'],
            'first_class' => $data['first_class_seats'],
        ]);

        Session::flash('success', 'Flight created successfully.');
        redirect('admin/flights');
    }

    public function flightEdit(string $id): void
    {
        $this->requireAdmin();
        $flight = Database::fetch('SELECT * FROM flights WHERE id = ?', [(int) $id]);
        $airlines = Airline::getAll(true);
        $airports = Airport::getAll(true);
        view('admin.flights.edit', compact('flight', 'airlines', 'airports'), 'admin');
    }

    public function flightUpdate(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/flights');
        $this->verifyCsrf();

        $dep = post('departure_time');
        $arr = post('arrival_time');
        Flight::update((int) $id, [
            'flight_number' => Security::sanitize(post('flight_number')),
            'airline_id' => (int) post('airline_id'),
            'aircraft_type' => Security::sanitize(post('aircraft_type')),
            'departure_airport_id' => (int) post('departure_airport_id'),
            'arrival_airport_id' => (int) post('arrival_airport_id'),
            'departure_time' => $dep,
            'arrival_time' => $arr,
            'duration_minutes' => max(0, (int) ((strtotime($arr) - strtotime($dep)) / 60)),
            'stops' => (int) post('stops', 0),
            'economy_price' => (float) post('economy_price'),
            'premium_economy_price' => (float) post('premium_economy_price'),
            'business_price' => (float) post('business_price'),
            'first_class_price' => (float) post('first_class_price'),
            'status' => post('status', 'scheduled'),
        ]);

        Session::flash('success', 'Flight updated successfully.');
        redirect('admin/flights');
    }

    public function flightDelete(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/flights');
        $this->verifyCsrf();
        Flight::delete((int) $id);
        Session::flash('success', 'Flight deleted.');
        redirect('admin/flights');
    }

    // Airlines
    public function airlines(): void
    {
        $this->requireAdmin();
        $airlines = Airline::getAll();
        view('admin.airlines.index', compact('airlines'), 'admin');
    }

    public function airlineStore(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airlines');
        $this->verifyCsrf();

        $data = [
            'name' => Security::sanitize(post('name')),
            'code' => strtoupper(Security::sanitize(post('code'))),
            'contact_email' => Security::sanitize(post('contact_email')),
            'contact_phone' => Security::sanitize(post('contact_phone')),
            'website' => Security::sanitize(post('website')),
            'description' => Security::sanitize(post('description')),
            'status' => post('status', 'active'),
        ];
        if (!empty($_FILES['logo']['name'])) {
            $logo = uploadFile($_FILES['logo'], config('app.upload.airlines_path'), config('app.upload.allowed_images'));
            if ($logo) $data['logo'] = $logo;
        }
        Airline::create($data);
        Session::flash('success', 'Airline created.');
        redirect('admin/airlines');
    }

    public function airlineUpdate(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airlines');
        $this->verifyCsrf();

        $data = [
            'name' => Security::sanitize(post('name')),
            'code' => strtoupper(Security::sanitize(post('code'))),
            'contact_email' => Security::sanitize(post('contact_email')),
            'contact_phone' => Security::sanitize(post('contact_phone')),
            'website' => Security::sanitize(post('website')),
            'description' => Security::sanitize(post('description')),
            'status' => post('status', 'active'),
        ];
        if (!empty($_FILES['logo']['name'])) {
            $logo = uploadFile($_FILES['logo'], config('app.upload.airlines_path'), config('app.upload.allowed_images'));
            if ($logo) $data['logo'] = $logo;
        }
        Airline::update((int) $id, $data);
        Session::flash('success', 'Airline updated.');
        redirect('admin/airlines');
    }

    public function airlineDelete(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airlines');
        $this->verifyCsrf();
        Airline::delete((int) $id);
        Session::flash('success', 'Airline deleted.');
        redirect('admin/airlines');
    }

    // Airports
    public function airports(): void
    {
        $this->requireAdmin();
        $airports = Airport::getAll();
        view('admin.airports.index', compact('airports'), 'admin');
    }

    public function airportStore(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airports');
        $this->verifyCsrf();
        Airport::create([
            'name' => Security::sanitize(post('name')),
            'code' => strtoupper(Security::sanitize(post('code'))),
            'city' => Security::sanitize(post('city')),
            'country' => Security::sanitize(post('country')),
            'timezone' => Security::sanitize(post('timezone', 'UTC')),
            'status' => post('status', 'active'),
        ]);
        Session::flash('success', 'Airport created.');
        redirect('admin/airports');
    }

    public function airportUpdate(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airports');
        $this->verifyCsrf();
        Airport::update((int) $id, [
            'name' => Security::sanitize(post('name')),
            'code' => strtoupper(Security::sanitize(post('code'))),
            'city' => Security::sanitize(post('city')),
            'country' => Security::sanitize(post('country')),
            'timezone' => Security::sanitize(post('timezone', 'UTC')),
            'status' => post('status', 'active'),
        ]);
        Session::flash('success', 'Airport updated.');
        redirect('admin/airports');
    }

    public function airportDelete(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/airports');
        $this->verifyCsrf();
        Airport::delete((int) $id);
        Session::flash('success', 'Airport deleted.');
        redirect('admin/airports');
    }

    // Bookings
    public function bookings(): void
    {
        $this->requireAdmin();
        $bookings = Booking::getAll();
        view('admin.bookings.index', compact('bookings'), 'admin');
    }

    public function bookingUpdateStatus(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/bookings');
        $this->verifyCsrf();
        Booking::update((int) $id, ['status' => post('status')]);
        Session::flash('success', 'Booking status updated.');
        redirect('admin/bookings');
    }

    // Payments
    public function payments(): void
    {
        $this->requireAdmin();
        $payments = Payment::getAll();
        view('admin.payments.index', compact('payments'), 'admin');
    }

    // Users
    public function users(): void
    {
        $this->requireAdmin();
        $users = User::getAll();
        view('admin.users.index', compact('users'), 'admin');
    }

    public function userUpdateStatus(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/users');
        $this->verifyCsrf();
        User::update((int) $id, ['status' => post('status')]);
        Session::flash('success', 'User status updated.');
        redirect('admin/users');
    }

    // Coupons
    public function coupons(): void
    {
        $this->requireAdmin();
        $coupons = Coupon::getAll();
        view('admin.coupons.index', compact('coupons'), 'admin');
    }

    public function couponStore(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/coupons');
        $this->verifyCsrf();
        Coupon::create([
            'code' => Security::sanitize(post('code')),
            'description' => Security::sanitize(post('description')),
            'discount_type' => post('discount_type'),
            'discount_value' => (float) post('discount_value'),
            'min_amount' => (float) post('min_amount', 0),
            'max_uses' => post('max_uses') ? (int) post('max_uses') : null,
            'expires_at' => post('expires_at') ?: null,
            'status' => post('status', 'active'),
        ]);
        Session::flash('success', 'Coupon created.');
        redirect('admin/coupons');
    }

    public function couponDelete(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/coupons');
        $this->verifyCsrf();
        Coupon::delete((int) $id);
        Session::flash('success', 'Coupon deleted.');
        redirect('admin/coupons');
    }

    // Reviews
    public function reviews(): void
    {
        $this->requireAdmin();
        $reviews = Review::getAll();
        view('admin.reviews.index', compact('reviews'), 'admin');
    }

    public function reviewUpdate(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/reviews');
        $this->verifyCsrf();
        Review::update((int) $id, ['status' => post('status')]);
        Session::flash('success', 'Review updated.');
        redirect('admin/reviews');
    }

    // Support
    public function support(): void
    {
        $this->requireAdmin();
        $tickets = SupportTicket::getAll();
        view('admin.support.index', compact('tickets'), 'admin');
    }

    public function supportReply(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/support');
        $this->verifyCsrf();
        SupportTicket::update((int) $id, [
            'admin_reply' => Security::sanitize(post('admin_reply')),
            'status' => post('status', 'resolved'),
        ]);
        Session::flash('success', 'Reply sent.');
        redirect('admin/support');
    }

    // FAQs
    public function faqs(): void
    {
        $this->requireAdmin();
        $faqs = Faq::getAll();
        view('admin.faqs.index', compact('faqs'), 'admin');
    }

    public function faqStore(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/faqs');
        $this->verifyCsrf();
        Faq::create([
            'question' => Security::sanitize(post('question')),
            'answer' => Security::sanitize(post('answer')),
            'category' => Security::sanitize(post('category', 'General')),
            'sort_order' => (int) post('sort_order', 0),
            'status' => post('status', 'active'),
        ]);
        Session::flash('success', 'FAQ created.');
        redirect('admin/faqs');
    }

    public function faqDelete(string $id): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/faqs');
        $this->verifyCsrf();
        Faq::delete((int) $id);
        Session::flash('success', 'FAQ deleted.');
        redirect('admin/faqs');
    }

    // Reports
    public function reports(): void
    {
        $this->requireAdmin();
        view('admin.reports.index', [], 'admin');
    }

    public function generateReport(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/reports');
        $this->verifyCsrf();

        $type = post('report_type', 'bookings');
        $data = match ($type) {
            'flights' => Flight::getAll(1, 1000),
            'revenue' => Booking::getMonthlyRevenue(),
            'bookings' => Booking::getAll(1, 1000),
            'passengers' => Passenger::getAll(1, 1000),
            default => [],
        };

        $filename = "report_{$type}_" . date('Y-m-d') . ".csv";
        $filepath = BASE_PATH . '/uploads/' . $filename;
        $fp = fopen($filepath, 'w');
        if (!empty($data)) {
            fputcsv($fp, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($fp, $row);
            }
        }
        fclose($fp);

        Database::insert('reports', [
            'report_type' => $type,
            'title' => ucfirst($type) . ' Report - ' . date('Y-m-d'),
            'generated_by' => Session::userId(),
            'file_path' => $filename,
        ]);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filepath);
        exit;
    }

    // Settings
    public function settings(): void
    {
        $this->requireAdmin();
        $settings = Setting::getAll();
        view('admin.settings', compact('settings'), 'admin');
    }

    public function settingsUpdate(): void
    {
        $this->requireAdmin();
        if (!isPost()) redirect('admin/settings');
        $this->verifyCsrf();
        $keys = ['site_name', 'site_email', 'site_phone', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'stripe_public_key', 'stripe_secret_key', 'paypal_client_id'];
        foreach ($keys as $key) {
            if (post($key) !== null) {
                Setting::set($key, Security::sanitize(post($key)));
            }
        }
        Session::flash('success', 'Settings updated.');
        redirect('admin/settings');
    }

    // Passengers
    public function passengers(): void
    {
        $this->requireAdmin();
        $passengers = Passenger::getAll();
        view('admin.passengers.index', compact('passengers'), 'admin');
    }
}
