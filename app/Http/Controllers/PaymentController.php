<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\PayPalService;
use App\Services\StripeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PaymentController
{
    use ApiResponse;

    public function __construct(
        private StripeService $stripeService,
        private PayPalService $payPalService,
        private PaymentService $paymentService,
    ) {
    }

    public function handleStripeWebhook(Request $request)
    {
        $event = $this->stripeService->verifyWebhook($request->getContent(), (string) $request->header('Stripe-Signature'));

        if (($event['type'] ?? null) === 'payment_intent.succeeded') {
            $payment = Payment::query()->findOrFail($event['data']['object']['metadata']['payment_id'] ?? 0);
            $this->paymentService->markAsPaid($payment, (string) $event['data']['object']['id']);
        }

        return $this->success('Webhook processed.');
    }

    public function paypalSuccess(Request $request)
    {
        $payment = Payment::query()->findOrFail((int) $request->query('payment'));
        $capture = $this->payPalService->capture((string) $request->query('token', '')); 

        if (($capture['status'] ?? '') === 'COMPLETED') {
            $this->paymentService->markAsPaid($payment, (string) $capture['id']);
            return $this->success('PayPal payment captured.');
        }

        $payment->update(['status' => 'failed']);
        return $this->error('PayPal payment failed.', null, 422);
    }

    public function paypalCancel()
    {
        return $this->error('PayPal payment cancelled by customer.', null, 422);
    }
}
