<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Services\InventoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
class OrderController { use ApiResponse; public function __construct(private InventoryService $inventoryService){} public function index(Request $r){ return $this->success('Orders fetched.', $r->user()->orders()->latest()->paginate()); } public function show(Request $r, Order $order){ abort_unless($order->user_id===$r->user()->id,403); return $this->success('Order fetched.',$order->load('items')); } public function cancel(Request $r, Order $order){ abort_unless($order->user_id===$r->user()->id,403); if(!in_array($order->status,['pending','processing'])) abort(422,'Order cannot be cancelled.'); $order->update(['status'=>'cancelled']); if($order->payment_status==='paid'){$this->inventoryService->restoreForOrder($order);} return $this->success('Order cancelled.',$order->fresh()); }}
