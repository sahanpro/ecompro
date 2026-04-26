<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ShippingMethod extends Model { protected $fillable=['name','zone','type','flat_rate','free_shipping_above','is_active','eta_days']; public function calculateFee(float $subtotal): float { if($this->type==='free_above' && $this->free_shipping_above && $subtotal >= $this->free_shipping_above){return 0;} return (float)$this->flat_rate; } }
