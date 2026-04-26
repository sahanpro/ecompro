<?php

namespace App\Services;

use App\Models\Payment;

class PayPalService
{
    public function createOrder(Payment $payment): array
    {
        return [
            'provider' => 'paypal',
            'approval_url' => url('/api/payments/paypal/success?payment=' . $payment->id),
            'amount' => $payment->amount,
        ];
    }

    public function capture(string $paypalOrderId): array
    {
        return ['status' => 'COMPLETED', 'id' => $paypalOrderId];
    }
}
