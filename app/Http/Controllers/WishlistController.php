<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class WishlistController { use ApiResponse; public function index(Request $r){ return $this->success('Wishlist fetched.', $r->user()->wishlist()->with('product')->get()); } public function store(Request $r, Product $product){ $r->user()->wishlist()->firstOrCreate(['product_id'=>$product->id]); return $this->success('Product added to wishlist.'); } public function destroy(Request $r, Product $product){ $r->user()->wishlist()->where('product_id',$product->id)->delete(); return $this->success('Product removed from wishlist.'); }}
