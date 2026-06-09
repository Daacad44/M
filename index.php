<?php

require_once __DIR__ . '/includes/bootstrap.php';

$router = new Router();

// Public routes
$router->get('/', 'Home', 'index');
$router->get('/about', 'Home', 'about');
$router->post('/newsletter', 'Home', 'newsletter');

// Auth routes
$router->get('/login', 'Auth', 'loginForm');
$router->post('/login', 'Auth', 'login');
$router->get('/register', 'Auth', 'registerForm');
$router->post('/register', 'Auth', 'register');
$router->get('/logout', 'Auth', 'logout');
$router->get('/verify-email/{token}', 'Auth', 'verifyEmail');
$router->get('/forgot-password', 'Auth', 'forgotForm');
$router->post('/forgot-password', 'Auth', 'forgot');
$router->get('/reset-password/{token}', 'Auth', 'resetForm');
$router->post('/reset-password/{token}', 'Auth', 'reset');

// Flight routes
$router->get('/flights/search', 'Flight', 'search');
$router->get('/flights/{id}', 'Flight', 'details');
$router->get('/api/airports', 'Flight', 'airportSearch');

// Booking routes
$router->get('/booking/create', 'Booking', 'create');
$router->post('/booking/store', 'Booking', 'store');
$router->get('/booking/review/{id}', 'Booking', 'review');
$router->post('/booking/confirm/{id}', 'Booking', 'confirm');
$router->post('/booking/cancel/{id}', 'Booking', 'cancel');
$router->post('/api/validate-coupon', 'Booking', 'validateCoupon');

// Payment routes
$router->get('/payment/{id}', 'Payment', 'show');
$router->post('/payment/process', 'Payment', 'process');
$router->post('/admin/payments/approve/{id}', 'Payment', 'approve');

// User routes
$router->get('/user/dashboard', 'User', 'dashboard');
$router->get('/user/bookings', 'User', 'bookings');
$router->get('/user/bookings/{id}', 'User', 'bookingDetail');
$router->get('/user/profile', 'User', 'profile');
$router->post('/user/profile', 'User', 'updateProfile');
$router->post('/user/change-password', 'User', 'changePassword');
$router->get('/user/notifications', 'User', 'notifications');
$router->get('/user/ticket/download/{id}', 'User', 'downloadTicket');
$router->post('/user/review', 'User', 'addReview');
$router->get('/user/support', 'User', 'support');
$router->post('/user/support', 'User', 'createTicket');

// Contact routes
$router->get('/contact', 'Contact', 'index');
$router->post('/contact', 'Contact', 'submit');
$router->post('/contact/ticket', 'Contact', 'createTicket');

// Admin routes
$router->get('/admin', 'Admin', 'dashboard');
$router->get('/admin/flights', 'Admin', 'flights');
$router->get('/admin/flights/create', 'Admin', 'flightCreate');
$router->post('/admin/flights/store', 'Admin', 'flightStore');
$router->get('/admin/flights/edit/{id}', 'Admin', 'flightEdit');
$router->post('/admin/flights/update/{id}', 'Admin', 'flightUpdate');
$router->post('/admin/flights/delete/{id}', 'Admin', 'flightDelete');
$router->get('/admin/airlines', 'Admin', 'airlines');
$router->post('/admin/airlines/store', 'Admin', 'airlineStore');
$router->post('/admin/airlines/update/{id}', 'Admin', 'airlineUpdate');
$router->post('/admin/airlines/delete/{id}', 'Admin', 'airlineDelete');
$router->get('/admin/airports', 'Admin', 'airports');
$router->post('/admin/airports/store', 'Admin', 'airportStore');
$router->post('/admin/airports/update/{id}', 'Admin', 'airportUpdate');
$router->post('/admin/airports/delete/{id}', 'Admin', 'airportDelete');
$router->get('/admin/bookings', 'Admin', 'bookings');
$router->post('/admin/bookings/status/{id}', 'Admin', 'bookingUpdateStatus');
$router->get('/admin/payments', 'Admin', 'payments');
$router->get('/admin/users', 'Admin', 'users');
$router->post('/admin/users/status/{id}', 'Admin', 'userUpdateStatus');
$router->get('/admin/coupons', 'Admin', 'coupons');
$router->post('/admin/coupons/store', 'Admin', 'couponStore');
$router->post('/admin/coupons/delete/{id}', 'Admin', 'couponDelete');
$router->get('/admin/reviews', 'Admin', 'reviews');
$router->post('/admin/reviews/update/{id}', 'Admin', 'reviewUpdate');
$router->get('/admin/support', 'Admin', 'support');
$router->post('/admin/support/reply/{id}', 'Admin', 'supportReply');
$router->get('/admin/faqs', 'Admin', 'faqs');
$router->post('/admin/faqs/store', 'Admin', 'faqStore');
$router->post('/admin/faqs/delete/{id}', 'Admin', 'faqDelete');
$router->get('/admin/reports', 'Admin', 'reports');
$router->post('/admin/reports/generate', 'Admin', 'generateReport');
$router->get('/admin/settings', 'Admin', 'settings');
$router->post('/admin/settings', 'Admin', 'settingsUpdate');
$router->get('/admin/passengers', 'Admin', 'passengers');

$router->dispatch();
