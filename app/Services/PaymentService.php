<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    public function __construct(
        private StripeService $stripeService,
        private PayPalService $payPalService,
        private InventoryService $inventoryService,
    ) {
    }

    public function initPayment(Order $order, string $method): array
    {
        $payment = Payment::query()->create([
            'order_id' => $order->id,
            'method' => $method,
            'status' => 'pending',
            'amount' => $order->grand_total,
            'currency' => $order->currency,
        ]);

        return match ($method) {
            'stripe' => $this->stripeService->createIntent($payment),
            'paypal' => $this->payPalService->createOrder($payment),
            'cod' => ['provider' => 'cod', 'status' => 'pending'],
            default => throw new \InvalidArgumentException('Unsupported payment method'),
        };
    }

    public function markAsPaid(Payment $payment, string $transactionId): void
    {
        $payment->update(['status' => 'paid', 'transaction_id' => $transactionId, 'paid_at' => now()]);
        $payment->order->update(['payment_status' => 'paid', 'status' => 'processing']);
        $this->inventoryService->reserveForOrder($payment->order);
    }
}
