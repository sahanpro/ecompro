<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model { protected $fillable=['user_id','invoice_no','shipping_address_id','billing_address_id','status','payment_status','subtotal','discount_total','tax_total','shipping_total','grand_total','currency']; public function items(){return $this->hasMany(OrderItem::class);} public function payment(){return $this->hasOne(Payment::class);} }
