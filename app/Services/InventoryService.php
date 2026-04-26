<?php

namespace App\Services;

use App\Models\Order;

class InventoryService
{
    public function reserveForOrder(Order $order): void
    {
        foreach ($order->items as $item) {
            $variant = $item->variant()->lockForUpdate()->first();
            if ($variant->stock_qty < $item->quantity) {
                abort(422, "Insufficient stock for SKU {$variant->sku}");
            }
            $variant->decrement('stock_qty', $item->quantity);
            $variant->stockMovements()->create([
                'change' => -$item->quantity,
                'reason' => 'order_placed',
                'reference_type' => Order::class,
                'reference_id' => $order->id,
            ]);
        }
    }

    public function restoreForOrder(Order $order, string $reason = 'order_cancelled'): void
    {
        foreach ($order->items as $item) {
            $variant = $item->variant;
            $variant->increment('stock_qty', $item->quantity);
            $variant->stockMovements()->create([
                'change' => $item->quantity,
                'reason' => $reason,
                'reference_type' => Order::class,
                'reference_id' => $order->id,
            ]);
        }
    }
}
