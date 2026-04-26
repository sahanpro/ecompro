<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ProductVariant;

class CartService
{
    public function addItem(int $userId, int $variantId, int $quantity): Cart
    {
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $variant = ProductVariant::query()->findOrFail($variantId);

        if ($variant->stock_qty < $quantity) {
            abort(422, 'Requested quantity exceeds stock.');
        }

        $item = $cart->items()->firstOrNew(['product_variant_id' => $variantId]);
        $item->quantity = ($item->quantity ?? 0) + $quantity;
        $item->unit_price = $variant->price;
        $item->save();

        return $cart->load('items.variant.product');
    }

    public function totals(Cart $cart): array
    {
        $subtotal = $cart->items->sum(fn ($item) => $item->quantity * $item->unit_price);

        return [
            'subtotal' => round($subtotal, 2),
            'items_count' => $cart->items->sum('quantity'),
        ];
    }
}
