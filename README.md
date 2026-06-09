# SkyWings - Enterprise Online Flight Booking System

A complete, production-ready flight booking platform built with **PHP**, **MySQL**, **Bootstrap 5**, and **AJAX**. Designed for shared hosting environments including InfinityFree, ByetHost, and AwardSpace.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)

## Features

- **Public Website** - Modern landing page with hero, search, destinations, testimonials, FAQ
- **User Authentication** - Registration, login, email verification, forgot/reset password, remember me
- **Flight Search** - One-way, round-trip, multi-city with advanced filters
- **Booking System** - Passenger details, seat selection, coupon codes, booking references
- **Payment Module** - Stripe, PayPal, bank transfer, manual approval
- **E-Ticket System** - PDF download with QR codes
- **Email Notifications** - PHPMailer SMTP integration
- **User Dashboard** - Bookings, profile, notifications, support tickets
- **Admin Panel** - Analytics, CRUD for all entities, reports, settings
- **Security** - PDO, CSRF, XSS protection, rate limiting, bcrypt hashing

## Quick Start

```bash
# 1. Clone the repository
git clone <repo-url>
cd skywings

# 2. Configure environment
cp .env.example .env
# Edit .env with your database credentials

# 3. Import database
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql

# 4. Set permissions
chmod -R 755 uploads/

# 5. Access the application
# Website: http://localhost
# Admin:   http://localhost/admin
```

## Default Credentials

| Role  | Email              | Password   |
|-------|--------------------|------------|
| Admin | admin@skywings.com | Admin@123  |
| User  | user@skywings.com  | User@123   |

## Project Structure

```
/config          Application configuration
/controllers     MVC Controllers
/models          Database models
/views           View templates (layouts, partials, pages)
/includes        Core libraries (Database, Security, Router, Mailer)
/assets          CSS, JavaScript, images
/uploads         User uploads
/database        SQL schema and seed data
/docs            Installation and deployment guides
```

## Documentation

- [Installation Guide](docs/INSTALLATION.md)
- [InfinityFree Deployment](docs/INFINITYFREE_DEPLOYMENT.md)
- [Technical Documentation](docs/DOCUMENTATION.md)

## Tech Stack

- PHP 8.0+ (MVC Architecture)
- MySQL 5.7+ / MariaDB 10.3+
- Bootstrap 5.3, Font Awesome 6, SweetAlert2, DataTables, Chart.js
- PHPMailer (SMTP), FPDF (PDF tickets)
- Apache mod_rewrite

## Hosting Compatibility

Tested and compatible with:
- [InfinityFree](https://infinityfree.com)
- [ByetHost](https://byet.host)
- [AwardSpace](https://www.awardspace.com)
- Any shared hosting with PHP 8.0+ and MySQL

## Sample Data

The seed file includes:
- 5 airlines with contact details
- 12 international airports
- 12 sample flights with dynamic dates
- 3 promo codes (WELCOME10, SAVE50, SUMMER25)
- 8 FAQs
- Admin and demo user accounts

## Security

- Prepared statements (PDO) for all database queries
- CSRF protection on all forms
- XSS output escaping
- Bcrypt password hashing
- Rate limiting on authentication endpoints
- Secure session configuration
- Protected directories via `.htaccess`

## License

Open source - free for educational and commercial use.
