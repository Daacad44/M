# SkyWings Flight Booking System - Installation Guide

## Requirements

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache with mod_rewrite enabled
- PDO MySQL extension
- GD extension (for QR codes in tickets)
- OpenSSL extension

## Quick Installation

### 1. Upload Files

Upload all project files to your web server's document root (e.g., `public_html` or `htdocs`).

### 2. Configure Environment

Copy `.env.example` to `.env` and update the values:

```bash
cp .env.example .env
```

Edit `.env`:

```env
APP_URL=https://yourdomain.com
APP_DEBUG=false

DB_HOST=localhost
DB_PORT=3306
DB_NAME=skywings_flights
DB_USER=your_db_user
DB_PASS=your_db_password

SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
```

### 3. Create Database

1. Log in to phpMyAdmin or MySQL CLI
2. Import `database/schema.sql` to create the database and tables
3. Import `database/seed.sql` to load sample data and admin account

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

### 4. Set Permissions

Ensure the `uploads` directory is writable:

```bash
chmod -R 755 uploads/
```

### 5. Access the Application

- **Website:** `https://yourdomain.com`
- **Admin Panel:** `https://yourdomain.com/admin`

### Default Credentials

| Role  | Email               | Password   |
|-------|---------------------|------------|
| Admin | admin@skywings.com  | Admin@123  |
| User  | user@skywings.com   | User@123   |

**Change these passwords immediately after installation.**

## Directory Structure

```
/config          - Application configuration
/controllers     - MVC Controllers
/models          - Database models
/views           - View templates
/includes        - Core libraries and helpers
/assets          - CSS, JS, images
/uploads         - User uploads (airlines, avatars, tickets)
/database        - SQL schema and seed files
/docs            - Documentation
```

## SMTP Configuration

For Gmail SMTP:
1. Enable 2-Factor Authentication on your Google account
2. Generate an App Password at https://myaccount.google.com/apppasswords
3. Use the app password in `SMTP_PASS`

## Payment Gateway Setup

Configure Stripe and PayPal keys in Admin → Settings, or in the `.env` file.

## Troubleshooting

| Issue | Solution |
|-------|----------|
| 404 on all pages | Enable mod_rewrite; ensure `.htaccess` is uploaded |
| Database connection error | Verify `.env` database credentials |
| Emails not sending | Check SMTP settings; test with Admin → Settings |
| Upload fails | Set `uploads/` directory permissions to 755 |
| White screen | Set `APP_DEBUG=true` temporarily to see errors |

## Security Checklist

- [ ] Change default admin password
- [ ] Set `APP_DEBUG=false` in production
- [ ] Use HTTPS (SSL certificate)
- [ ] Restrict `database/` and `config/` from web access (handled by `.htaccess`)
- [ ] Configure SMTP for email verification
