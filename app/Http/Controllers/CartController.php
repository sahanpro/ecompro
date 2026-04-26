<?php
namespace App\Http\Controllers;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class CartController { use ApiResponse; public function __construct(private CartService $cartService){} public function show(Request $r){$cart=$r->user()->cart()->with('items.variant.product')->firstOrCreate(); return $this->success('Cart fetched.',$cart);} public function addItem(Request $r){$d=$r->validate(['product_variant_id'=>['required','int'],'quantity'=>['required','int','min:1']]); return $this->success('Item added.',$this->cartService->addItem($r->user()->id,$d['product_variant_id'],$d['quantity']));} public function updateItem(Request $r, CartItem $item){$d=$r->validate(['quantity'=>['required','int','min:1']]); $item->update($d); return $this->success('Cart item updated.',$item->fresh());} public function removeItem(CartItem $item){$item->delete(); return $this->success('Cart item removed.');} public function clear(Request $r){$r->user()->cart?->items()->delete(); return $this->success('Cart cleared.');}}
