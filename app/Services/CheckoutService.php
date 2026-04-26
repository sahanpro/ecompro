<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(
        private CartService $cartService,
        private CouponService $couponService,
        private OrderService $orderService,
        private PaymentService $paymentService,
    ) {
    }

    public function summary(User $user, ?string $couponCode, int $shippingMethodId): array
    {
        $cart = $user->cart()->with('items')->firstOrFail();
        $base = $this->cartService->totals($cart);
        $couponData = $this->couponService->validate($couponCode, $base['subtotal']);
        $shipping = (float) \App\Models\ShippingMethod::query()->findOrFail($shippingMethodId)->calculateFee($base['subtotal']);
        $tax = round(($base['subtotal'] - $couponData['discount']) * (config('services.tax_percent', 10) / 100), 2);
        $grand = max(0, round($base['subtotal'] - $couponData['discount'] + $shipping + $tax, 2));

        return [
            'subtotal' => $base['subtotal'],
            'discount' => $couponData['discount'],
            'shipping' => $shipping,
            'tax' => $tax,
            'grand_total' => $grand,
            'coupon' => $couponData['coupon']?->code,
        ];
    }

    public function placeOrder(User $user, array $payload): array
    {
        return DB::transaction(function () use ($user, $payload) {
            $pricing = $this->summary($user, $payload['coupon_code'] ?? null, $payload['shipping_method_id']);
            $order = $this->orderService->createFromCart($user, $pricing, $payload);
            $paymentMeta = $this->paymentService->initPayment($order, $payload['payment_method']);
            $user->cart->items()->delete();

            return ['order' => $order->fresh('items'), 'payment' => $paymentMeta];
        });
    }
}
