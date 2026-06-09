<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once BASE_PATH . '/includes/lib/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/includes/lib/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/includes/lib/PHPMailer/src/SMTP.php';

class Mailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $config = require BASE_PATH . '/config/mail.php';
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $config['smtp']['host'];
        $this->mail->SMTPAuth = !empty($config['smtp']['username']);
        $this->mail->Username = $config['smtp']['username'];
        $this->mail->Password = $config['smtp']['password'];
        $this->mail->SMTPSecure = $config['smtp']['encryption'];
        $this->mail->Port = $config['smtp']['port'];
        $this->mail->setFrom($config['from_email'], $config['from_name']);
        $this->mail->isHTML(true);
    }

    public function send(string $to, string $subject, string $body, ?string $toName = null): bool
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to, $toName ?? '');
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            return $this->mail->send();
        } catch (Exception $e) {
            if (config('app.debug')) {
                error_log('Mail error: ' . $e->getMessage());
            }
            return false;
        }
    }

    public static function sendWelcome(string $email, string $name, string $verifyLink): bool
    {
        $mailer = new self();
        $body = self::template('Welcome to SkyWings', "
            <h2>Welcome, {$name}!</h2>
            <p>Thank you for registering with SkyWings. Please verify your email address to activate your account.</p>
            <p><a href='{$verifyLink}' style='background:#0d6efd;color:#fff;padding:12px 24px;text-decoration:none;border-radius:5px;display:inline-block;'>Verify Email</a></p>
            <p>If you did not create this account, please ignore this email.</p>
        ");
        return $mailer->send($email, 'Welcome to SkyWings - Verify Your Email', $body, $name);
    }

    public static function sendBookingConfirmation(string $email, string $name, array $booking): bool
    {
        $mailer = new self();
        $ref = e($booking['booking_reference']);
        $amount = formatMoney((float) $booking['final_amount']);
        $body = self::template('Booking Confirmation', "
            <h2>Booking Confirmed!</h2>
            <p>Dear {$name},</p>
            <p>Your flight booking has been confirmed.</p>
            <table style='width:100%;border-collapse:collapse;margin:20px 0;'>
                <tr><td style='padding:8px;border:1px solid #ddd;'><strong>Reference</strong></td><td style='padding:8px;border:1px solid #ddd;'>{$ref}</td></tr>
                <tr><td style='padding:8px;border:1px solid #ddd;'><strong>Amount</strong></td><td style='padding:8px;border:1px solid #ddd;'>{$amount}</td></tr>
                <tr><td style='padding:8px;border:1px solid #ddd;'><strong>Status</strong></td><td style='padding:8px;border:1px solid #ddd;'>" . ucfirst($booking['status']) . "</td></tr>
            </table>
            <p><a href='" . url('user/bookings') . "' style='background:#0d6efd;color:#fff;padding:12px 24px;text-decoration:none;border-radius:5px;display:inline-block;'>View Booking</a></p>
        ");
        return $mailer->send($email, "Booking Confirmed - {$ref}", $body, $name);
    }

    public static function sendPaymentConfirmation(string $email, string $name, array $payment): bool
    {
        $mailer = new self();
        $amount = formatMoney((float) $payment['amount']);
        $body = self::template('Payment Confirmation', "
            <h2>Payment Received</h2>
            <p>Dear {$name},</p>
            <p>We have received your payment of <strong>{$amount}</strong>.</p>
            <p>Transaction ID: " . e($payment['transaction_id'] ?? 'N/A') . "</p>
            <p>Thank you for choosing SkyWings!</p>
        ");
        return $mailer->send($email, 'Payment Confirmation - SkyWings', $body, $name);
    }

    public static function sendPasswordReset(string $email, string $name, string $resetLink): bool
    {
        $mailer = new self();
        $body = self::template('Password Reset', "
            <h2>Reset Your Password</h2>
            <p>Dear {$name},</p>
            <p>Click the button below to reset your password. This link expires in 1 hour.</p>
            <p><a href='{$resetLink}' style='background:#0d6efd;color:#fff;padding:12px 24px;text-decoration:none;border-radius:5px;display:inline-block;'>Reset Password</a></p>
            <p>If you did not request this, please ignore this email.</p>
        ");
        return $mailer->send($email, 'Password Reset - SkyWings', $body, $name);
    }

    public static function sendFlightCancellation(string $email, string $name, array $booking): bool
    {
        $mailer = new self();
        $ref = e($booking['booking_reference']);
        $body = self::template('Flight Cancellation', "
            <h2>Flight Cancellation Notice</h2>
            <p>Dear {$name},</p>
            <p>Your booking <strong>{$ref}</strong> has been cancelled.</p>
            <p>If you have questions, please contact our support team.</p>
        ");
        return $mailer->send($email, "Flight Cancelled - {$ref}", $body, $name);
    }

    private static function template(string $title, string $content): string
    {
        $siteName = config('app.name', 'SkyWings');
        return "
        <!DOCTYPE html><html><head><meta charset='UTF-8'></head>
        <body style='font-family:Arial,sans-serif;line-height:1.6;color:#333;max-width:600px;margin:0 auto;padding:20px;'>
            <div style='background:linear-gradient(135deg,#0d6efd,#0dcaf0);padding:20px;text-align:center;border-radius:8px 8px 0 0;'>
                <h1 style='color:#fff;margin:0;'>{$siteName}</h1>
            </div>
            <div style='background:#f8f9fa;padding:30px;border-radius:0 0 8px 8px;'>
                {$content}
            </div>
            <p style='text-align:center;color:#999;font-size:12px;margin-top:20px;'>&copy; " . date('Y') . " {$siteName}. All rights reserved.</p>
        </body></html>";
    }
}
