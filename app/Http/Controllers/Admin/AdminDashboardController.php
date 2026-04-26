<?php
namespace App\Http\Controllers\Admin;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use App\Traits\ApiResponse;
class AdminDashboardController { use ApiResponse; public function __invoke(){ return $this->success('Dashboard stats fetched.', ['total_sales'=>Order::where('payment_status','paid')->sum('grand_total'),'total_orders'=>Order::count(),'total_customers'=>User::where('role','customer')->count(),'pending_orders'=>Order::where('status','pending')->count(),'low_stock_products'=>ProductVariant::where('stock_qty','<',config('services.low_stock_threshold',5))->count(),'recent_orders'=>Order::latest()->limit(10)->get()]); }}
