<?php

class Newsletter
{
    public static function subscribe(string $email): bool
    {
        $existing = Database::fetch('SELECT * FROM newsletter_subscribers WHERE email = ?', [$email]);
        if ($existing) {
            if ($existing['status'] === 'unsubscribed') {
                Database::update('newsletter_subscribers', ['status' => 'active'], 'id = ?', [$existing['id']]);
            }
            return true;
        }
        Database::insert('newsletter_subscribers', ['email' => $email]);
        return true;
    }

    public static function getAll(): array
    {
        return Database::fetchAll("SELECT * FROM newsletter_subscribers WHERE status = 'active' ORDER BY subscribed_at DESC");
    }
}
