<?php

class Faq
{
    public static function getActive(): array
    {
        return Database::fetchAll(
            "SELECT * FROM faqs WHERE status = 'active' ORDER BY sort_order ASC, id ASC"
        );
    }

    public static function getAll(): array
    {
        return Database::fetchAll('SELECT * FROM faqs ORDER BY sort_order ASC');
    }

    public static function create(array $data): int
    {
        return Database::insert('faqs', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('faqs', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('faqs', 'id = ?', [$id]);
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM faqs WHERE id = ?', [$id]);
    }
}
