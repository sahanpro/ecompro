<?php
namespace App\Http\Controllers\Admin;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class AdminOrderController { use ApiResponse; public function index(){return $this->success('Orders fetched.',Order::latest()->paginate());} public function show(Order $order){return $this->success('Order fetched.',$order->load('items','payment'));} public function update(Request $r, Order $order){$d=$r->validate(['status'=>['required','in:pending,processing,shipped,delivered,cancelled,returned,refunded']]); $order->update($d); return $this->success('Order status updated.',$order->fresh());}}
