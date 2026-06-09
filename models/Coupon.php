<?php

class Coupon
{
    public static function findByCode(string $code): ?array
    {
        return Database::fetch(
            "SELECT * FROM coupons WHERE code = ? AND status = 'active' AND (expires_at IS NULL OR expires_at > NOW())",
            [strtoupper($code)]
        );
    }

    public static function validate(string $code, float $amount): array
    {
        $coupon = self::findByCode($code);
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon code.'];
        }
        if ($coupon['max_uses'] && $coupon['used_count'] >= $coupon['max_uses']) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }
        if ($amount < (float) $coupon['min_amount']) {
            return ['valid' => false, 'message' => 'Minimum order amount is ' . formatMoney((float) $coupon['min_amount']) . '.'];
        }

        $discount = $coupon['discount_type'] === 'percentage'
            ? $amount * ((float) $coupon['discount_value'] / 100)
            : (float) $coupon['discount_value'];

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => min($discount, $amount),
        ];
    }

    public static function apply(int $couponId): void
    {
        Database::query('UPDATE coupons SET used_count = used_count + 1 WHERE id = ?', [$couponId]);
    }

    public static function getAll(): array
    {
        return Database::fetchAll('SELECT * FROM coupons ORDER BY created_at DESC');
    }

    public static function create(array $data): int
    {
        $data['code'] = strtoupper($data['code']);
        return Database::insert('coupons', $data);
    }

    public static function update(int $id, array $data): int
    {
        if (isset($data['code'])) {
            $data['code'] = strtoupper($data['code']);
        }
        return Database::update('coupons', $data, 'id = ?', [$id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('coupons', 'id = ?', [$id]);
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM coupons WHERE id = ?', [$id]);
    }
}
