<?php

namespace App\Services;

use App\Models\Payment;

class StripeService
{
    public function createIntent(Payment $payment): array
    {
        return [
            'provider' => 'stripe',
            'client_secret' => 'set-by-stripe-sdk',
            'amount' => (int) round($payment->amount * 100),
            'currency' => strtolower($payment->currency),
        ];
    }

    public function verifyWebhook(string $payload, string $signature): array
    {
        if (!$signature) {
            abort(422, 'Invalid Stripe signature.');
        }

        return json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
    }
}
