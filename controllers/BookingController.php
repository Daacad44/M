<?php

class BookingController extends BaseController
{
    public function create(): void
    {
        $this->requireAuth();
        $flightId = (int) get('flight_id');
        $returnFlightId = (int) get('return_flight_id');
        $cabinClass = get('cabin_class', 'economy');
        $passengers = max(1, (int) get('passengers', 1));
        $tripType = get('trip_type', 'one_way');

        $flight = Flight::findById($flightId);
        if (!$flight) {
            Session::flash('error', 'Flight not found.');
            redirect('flights/search');
        }

        $returnFlight = $returnFlightId ? Flight::findById($returnFlightId) : null;
        $price = Flight::getPrice($flight, $cabinClass);
        $returnPrice = $returnFlight ? Flight::getPrice($returnFlight, $cabinClass) : 0;
        $totalPrice = ($price + $returnPrice) * $passengers;
        $seatMap = Seat::getSeatMap($flightId);

        view('booking.create', compact('flight', 'returnFlight', 'cabinClass', 'passengers', 'tripType', 'price', 'returnPrice', 'totalPrice', 'seatMap'));
    }

    public function store(): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('flights/search');
        }
        $this->verifyCsrf();

        $flightId = (int) post('flight_id');
        $returnFlightId = (int) post('return_flight_id');
        $cabinClass = post('cabin_class', 'economy');
        $tripType = post('trip_type', 'one_way');
        $couponCode = Security::sanitize(post('coupon_code', ''));
        $passengerData = post('passengers', []);

        $flight = Flight::findById($flightId);
        if (!$flight) {
            Session::flash('error', 'Flight not found.');
            redirect('flights/search');
        }

        $price = Flight::getPrice($flight, $cabinClass);
        $totalAmount = $price * count($passengerData);
        $returnFlight = null;

        if ($returnFlightId) {
            $returnFlight = Flight::findById($returnFlightId);
            if ($returnFlight) {
                $totalAmount += Flight::getPrice($returnFlight, $cabinClass) * count($passengerData);
            }
        }

        $discount = 0;
        $couponId = null;
        if ($couponCode) {
            $couponResult = Coupon::validate($couponCode, $totalAmount);
            if ($couponResult['valid']) {
                $discount = $couponResult['discount'];
                $couponId = $couponResult['coupon']['id'];
            }
        }

        $finalAmount = $totalAmount - $discount;
        $user = User::findById(Session::userId());
        $bookingRef = generateBookingReference();

        $bookingId = Booking::create([
            'user_id' => Session::userId(),
            'booking_reference' => $bookingRef,
            'trip_type' => $tripType,
            'cabin_class' => $cabinClass,
            'total_amount' => $totalAmount,
            'discount_amount' => $discount,
            'final_amount' => $finalAmount,
            'coupon_id' => $couponId,
            'status' => 'pending',
            'contact_email' => $user['email'],
            'contact_phone' => $user['phone'],
        ]);

        Booking::addFlight($bookingId, $flightId, 1, $price);
        if ($returnFlight) {
            Booking::addFlight($bookingId, $returnFlightId, 2, Flight::getPrice($returnFlight, $cabinClass));
        }

        $seatIds = post('seat_ids', []);
        foreach ($passengerData as $i => $p) {
            $seatId = !empty($seatIds[$i]) ? (int) $seatIds[$i] : null;
            if ($seatId) {
                Seat::reserve($seatId);
            }
            Passenger::create([
                'booking_id' => $bookingId,
                'passenger_type' => $p['type'] ?? 'adult',
                'title' => Security::sanitize($p['title'] ?? 'Mr'),
                'first_name' => Security::sanitize($p['first_name'] ?? ''),
                'last_name' => Security::sanitize($p['last_name'] ?? ''),
                'gender' => $p['gender'] ?? 'male',
                'nationality' => Security::sanitize($p['nationality'] ?? ''),
                'passport_number' => Security::sanitize($p['passport_number'] ?? ''),
                'date_of_birth' => $p['date_of_birth'] ?? null,
                'email' => Security::sanitize($p['email'] ?? $user['email']),
                'phone' => Security::sanitize($p['phone'] ?? $user['phone']),
                'seat_id' => $seatId,
            ]);
        }

        if ($couponId) {
            Coupon::apply($couponId);
        }

        Notification::create(Session::userId(), 'booking', 'Booking Created', "Your booking {$bookingRef} has been created. Please complete payment.", url("payment/{$bookingId}"));

        Session::set('booking_review', [
            'booking_id' => $bookingId,
            'reference' => $bookingRef,
            'total' => $finalAmount,
        ]);

        redirect("booking/review/{$bookingId}");
    }

    public function review(string $id): void
    {
        $this->requireAuth();
        $booking = Booking::findById((int) $id);
        if (!$booking || $booking['user_id'] != Session::userId()) {
            Session::flash('error', 'Booking not found.');
            redirect('user/bookings');
        }
        $flights = Booking::getFlights((int) $id);
        $passengers = Passenger::getByBooking((int) $id);

        view('booking.review', compact('booking', 'flights', 'passengers'));
    }

    public function confirm(string $id): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect("booking/review/{$id}");
        }
        $this->verifyCsrf();

        $booking = Booking::findById((int) $id);
        if (!$booking || $booking['user_id'] != Session::userId()) {
            redirect('user/bookings');
        }

        redirect("payment/{$id}");
    }

    public function cancel(string $id): void
    {
        $this->requireAuth();
        if (!isPost()) {
            redirect('user/bookings');
        }
        $this->verifyCsrf();

        $booking = Booking::findById((int) $id);
        if (!$booking || ($booking['user_id'] != Session::userId() && !Session::isAdmin())) {
            Session::flash('error', 'Booking not found.');
            redirect('user/bookings');
        }

        Booking::update((int) $id, ['status' => 'cancelled']);
        $passengers = Passenger::getByBooking((int) $id);
        foreach ($passengers as $p) {
            if ($p['seat_id']) {
                Seat::release((int) $p['seat_id']);
            }
        }

        $user = User::findById($booking['user_id']);
        Mailer::sendFlightCancellation($user['email'], $user['full_name'], $booking);
        Notification::create($booking['user_id'], 'booking', 'Booking Cancelled', "Your booking {$booking['booking_reference']} has been cancelled.", url('user/bookings'));

        Session::flash('success', 'Booking cancelled successfully.');
        redirect(Session::isAdmin() ? 'admin/bookings' : 'user/bookings');
    }

    public function validateCoupon(): void
    {
        $code = Security::sanitize(post('code', ''));
        $amount = (float) post('amount', 0);
        $result = Coupon::validate($code, $amount);
        $this->json($result);
    }
}
