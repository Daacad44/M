# SkyWings Flight Booking System - Technical Documentation

## Overview

SkyWings is an enterprise-level online flight booking platform built with PHP, MySQL, and Bootstrap 5. It follows the MVC (Model-View-Controller) architecture and is designed for shared hosting compatibility.

## Architecture

```
Request → index.php → Router → Controller → Model → Database
                                      ↓
                                    View → Layout → Response
```

### Core Components

| Component | Location | Purpose |
|-----------|----------|---------|
| Front Controller | `index.php` | Entry point, route definitions |
| Router | `includes/Router.php` | URL routing and dispatch |
| Database | `includes/Database.php` | PDO wrapper with prepared statements |
| Security | `includes/Security.php` | CSRF, XSS, rate limiting, password hashing |
| Session | `includes/Session.php` | Session management, auth state |
| Mailer | `includes/Mailer.php` | PHPMailer SMTP integration |
| TicketGenerator | `includes/TicketGenerator.php` | PDF e-ticket generation with QR |

## Database Schema

### Core Tables

- **users** - User accounts (admin/user roles)
- **airlines** - Airline partners with logos
- **airports** - Airport directory with IATA codes
- **flights** - Flight schedules with multi-class pricing
- **seats** - Seat inventory per flight
- **bookings** - Booking records with references
- **booking_flights** - Flight legs per booking (multi-city support)
- **passengers** - Passenger details per booking
- **payments** - Payment transactions
- **tickets** - E-ticket records with QR codes
- **coupons** - Promo codes and discounts
- **reviews** - User reviews and ratings
- **notifications** - In-app notification center
- **support_tickets** - Customer support system
- **faqs** - FAQ management
- **settings** - System configuration key-value store

## Authentication Flow

1. Registration → Email verification token sent
2. Login → Session created, optional Remember Me cookie
3. Password Reset → Token with 1-hour expiry
4. CSRF token validated on all POST requests
5. Rate limiting on login, register, and contact forms

## Booking Workflow

```
Search Flights → Select Flight → Enter Passengers → Review → Payment → Confirmation → E-Ticket
```

1. User searches with filters (route, date, class, stops, price)
2. Selects flight and enters passenger details with optional seat selection
3. Applies coupon code (AJAX validation)
4. Reviews booking summary
5. Chooses payment method (Stripe/PayPal/Bank Transfer/Manual)
6. On payment confirmation: tickets generated, emails sent, seats booked

## Payment Methods

| Method | Behavior |
|--------|----------|
| Stripe | Simulated instant payment (integrate Stripe.js for production) |
| PayPal | Simulated instant payment (integrate PayPal SDK for production) |
| Bank Transfer | Pending until admin approval |
| Manual | Pending until admin approval |

## Security Features

- **PDO Prepared Statements** - SQL injection prevention
- **password_hash()** - Bcrypt password hashing
- **CSRF Tokens** - Cross-site request forgery protection
- **htmlspecialchars()** - XSS output escaping
- **Rate Limiting** - Brute force protection
- **Secure Sessions** - HttpOnly cookies, session regeneration
- **Input Validation** - Server-side validation on all forms
- **Directory Protection** - `.htaccess` blocks config/includes access

## API Endpoints

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/api/airports?q=` | Airport autocomplete search |
| POST | `/api/validate-coupon` | Coupon code validation |

## Admin Module

The admin panel provides:

- Dashboard with revenue charts (Chart.js)
- CRUD for flights, airlines, airports
- Booking and payment management
- User management with status control
- Coupon and FAQ management
- Review moderation
- Support ticket replies
- CSV report exports
- System settings (SMTP, payment keys)

## E-Ticket System

PDF tickets generated using FPDF containing:
- Passenger information
- Flight details
- Booking reference and ticket number
- QR code (via external API)
- Seat assignment

## Email Notifications

| Event | Template |
|-------|----------|
| Registration | Welcome + verification link |
| Booking Confirmed | Booking details + dashboard link |
| Payment Received | Transaction confirmation |
| Password Reset | Reset link (1-hour expiry) |
| Flight Cancelled | Cancellation notice |

## Frontend Stack

- Bootstrap 5.3.3
- Font Awesome 6.5
- SweetAlert2
- DataTables
- Chart.js (admin)
- jQuery 3.7

## Extending the System

### Adding a New Route

1. Add route in `index.php`:
   ```php
   $router->get('/my-page', 'MyController', 'myAction');
   ```
2. Create controller in `controllers/MyController.php`
3. Create view in `views/my/page.php`

### Adding a New Model

1. Create `models/MyModel.php` with static methods
2. Use `Database::fetch()`, `Database::insert()`, etc.

### Production Stripe Integration

Replace simulated payment in `PaymentController::process()` with Stripe PHP SDK checkout session creation using keys from settings.

## File Upload

Uploads stored in `uploads/` with randomized filenames. Allowed types configured in `config/app.php`. Max size: 2MB.

## Environment Variables

All configuration via `.env` file loaded in `includes/bootstrap.php`.

## License

Built for educational and commercial deployment on shared hosting platforms.
