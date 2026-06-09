# Deploying SkyWings on InfinityFree

This guide walks you through deploying the SkyWings Flight Booking System on [InfinityFree](https://infinityfree.com) free hosting.

## Prerequisites

- InfinityFree account (sign up at https://infinityfree.com)
- FTP client (FileZilla recommended) or use InfinityFree File Manager

## Step 1: Create Hosting Account

1. Log in to InfinityFree control panel (https://dash.infinityfree.com)
2. Click **Create Account**
3. Choose a subdomain (e.g., `skywings.rf.gd`) or use your own domain
4. Wait for account activation (usually instant)

## Step 2: Create MySQL Database

1. In the control panel, go to **MySQL Databases**
2. Click **Create Database**
3. Note down:
   - Database Name (e.g., `if0_12345678_skywings`)
   - Database Host (usually `sqlXXX.infinityfree.com`)
   - Username
   - Password

## Step 3: Import Database

1. Open **phpMyAdmin** from the control panel
2. Select your database
3. Go to **Import** tab
4. Upload and import `database/schema.sql`
5. Upload and import `database/seed.sql`

## Step 4: Upload Project Files

### Via File Manager

1. Go to **Online File Manager** in control panel
2. Navigate to `htdocs` folder
3. Upload all project files (extract ZIP if needed)
4. Ensure `index.php` and `.htaccess` are in the `htdocs` root

### Via FTP

```
Host: ftpupload.net (or your assigned FTP host)
Username: Your FTP username
Password: Your FTP password
Port: 21
```

Upload all files to the `htdocs` directory.

## Step 5: Configure Environment

1. Rename `.env.example` to `.env`
2. Edit `.env` with your InfinityFree database details:

```env
APP_URL=https://yoursite.rf.gd
APP_DEBUG=false

DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_NAME=if0_12345678_skywings
DB_USER=if0_12345678
DB_PASS=your_database_password
```

## Step 6: Set Folder Permissions

Using File Manager, set permissions:
- `uploads/` → 755 (or 775 if uploads fail)
- `uploads/airlines/` → 755
- `uploads/avatars/` → 755
- `uploads/tickets/` → 755

## Step 7: Test the Application

1. Visit `https://yoursite.rf.gd`
2. Login to admin: `admin@skywings.com` / `Admin@123`
3. Test flight search and booking flow

## InfinityFree Limitations & Workarounds

| Limitation | Workaround |
|------------|------------|
| No cron jobs | Manual tasks via admin panel |
| Email restrictions | Use external SMTP (Gmail with App Password) |
| 400 MySQL queries/hour | Optimize queries; cache where possible |
| No shell/SSH access | Use phpMyAdmin for database management |
| File size limits | Keep uploads under 2MB |
| Daily hit limit | Suitable for demo/small projects |

## SMTP on InfinityFree

InfinityFree blocks PHP `mail()` function. Use external SMTP:

1. Create Gmail App Password
2. Configure in `.env`:

```env
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your@gmail.com
SMTP_PASS=your-16-char-app-password
SMTP_ENCRYPTION=tls
```

3. Or configure via Admin → Settings after login

## Custom Domain (Optional)

1. Point your domain's nameservers to InfinityFree
2. Add domain in control panel → **Domains**
3. Update `APP_URL` in `.env`

## Similar Hosting Providers

The same steps apply to:
- **ByetHost** (https://byet.host)
- **AwardSpace** (https://www.awardspace.com)

Adjust database host and FTP details per provider's control panel.

## Troubleshooting

**500 Internal Server Error**
- Check `.htaccess` is uploaded
- Verify PHP version is 8.0+ in control panel
- Set `APP_DEBUG=true` temporarily

**Database Connection Failed**
- Use the exact host from MySQL Databases page (not `localhost`)
- Verify database name includes the prefix (e.g., `if0_xxxxx_`)

**CSS/JS Not Loading**
- Update `APP_URL` in `.env` to match your exact domain
- Ensure `assets/` folder is uploaded

**Emails Not Working**
- InfinityFree requires external SMTP
- Gmail App Password is the recommended solution

## Post-Deployment

1. Change admin password immediately
2. Update site settings in Admin → Settings
3. Add your airline logos in Admin → Airlines
4. Configure payment keys if using Stripe/PayPal
