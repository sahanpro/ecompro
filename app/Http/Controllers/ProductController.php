<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController
{
    use ApiResponse;

    public function index(Request $request)
    {
        $q = Product::query()->with(['category', 'brand'])
            ->when($request->filled('q'), fn ($qq) => $qq->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category_id'), fn ($qq) => $qq->where('category_id', $request->integer('category_id')))
            ->when($request->filled('brand_id'), fn ($qq) => $qq->where('brand_id', $request->integer('brand_id')))
            ->where('status', 'active');

        return $this->success('Products fetched.', $q->paginate(20));
    }

    public function show(Product $product) { return $this->success('Product fetched.', $product->load(['variants', 'images', 'reviews'])); }
}
