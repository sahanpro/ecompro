<?php
namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class AdminProductController { use ApiResponse; public function index(){ return $this->success('Admin products fetched.', Product::paginate()); } public function store(Request $r){$d=$r->validate(['name'=>['required'],'category_id'=>['required','int'],'brand_id'=>['nullable','int'],'status'=>['required','in:active,draft,out_of_stock'],'base_price'=>['required','numeric']]); return $this->success('Product created.', Product::create($d),201);} public function show(Product $product){ return $this->success('Product details fetched.', $product->load('variants')); } public function update(Request $r, Product $product){$product->update($r->all()); return $this->success('Product updated.',$product->fresh());} public function destroy(Product $product){$product->delete(); return $this->success('Product deleted.');}}
