<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CheckoutController
{
    use ApiResponse;

    public function __construct(private CheckoutService $checkoutService)
    {
    }

    public function summary(Request $request)
    {
        $data = $request->validate([
            'coupon_code' => ['nullable', 'string'],
            'shipping_method_id' => ['required', 'integer'],
        ]);

        return $this->success('Checkout summary generated.', $this->checkoutService->summary($request->user(), $data['coupon_code'] ?? null, $data['shipping_method_id']));
    }

    public function placeOrder(Request $request)
    {
        $payload = $request->validate([
            'shipping_address_id' => ['required', 'integer'],
            'billing_address_id' => ['required', 'integer'],
            'shipping_method_id' => ['required', 'integer'],
            'payment_method' => ['required', 'in:stripe,paypal,cod'],
            'coupon_code' => ['nullable', 'string'],
        ]);

        return $this->success('Order placed. Await payment confirmation.', $this->checkoutService->placeOrder($request->user(), $payload), 201);
    }
}
