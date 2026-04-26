<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function createFromCart(User $user, array $pricing, array $addressIds): Order
    {
        $cart = $user->cart()->with('items.variant')->firstOrFail();

        $order = Order::query()->create([
            'user_id' => $user->id,
            'invoice_no' => $this->generateInvoiceNo(),
            'shipping_address_id' => $addressIds['shipping_address_id'],
            'billing_address_id' => $addressIds['billing_address_id'],
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $pricing['subtotal'],
            'discount_total' => $pricing['discount'],
            'tax_total' => $pricing['tax'],
            'shipping_total' => $pricing['shipping'],
            'grand_total' => $pricing['grand_total'],
            'currency' => config('app.currency', 'USD'),
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->variant->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->variant->product->name,
                'sku' => $item->variant->sku,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'line_total' => $item->quantity * $item->unit_price,
            ]);
        }

        return $order->load('items');
    }

    public function generateInvoiceNo(): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }
}
