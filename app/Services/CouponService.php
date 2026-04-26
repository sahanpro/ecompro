<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function validate(?string $code, float $subtotal): array
    {
        if (!$code) {
            return ['discount' => 0, 'coupon' => null];
        }

        $coupon = Coupon::query()->where('code', $code)->where('is_active', true)->first();
        if (!$coupon || ($coupon->expires_at && now()->greaterThan($coupon->expires_at))) {
            abort(422, 'Invalid or expired coupon.');
        }

        if ($subtotal < $coupon->min_cart_amount) {
            abort(422, 'Cart total does not satisfy minimum amount for this coupon.');
        }

        $discount = $coupon->type === 'percentage'
            ? ($subtotal * ($coupon->value / 100))
            : min($coupon->value, $subtotal);

        return ['discount' => round($discount, 2), 'coupon' => $coupon];
    }
}
