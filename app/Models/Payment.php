<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model { protected $fillable=['order_id','method','status','amount','currency','transaction_id','paid_at']; protected $casts=['paid_at'=>'datetime']; public function order(){return $this->belongsTo(Order::class);} }
