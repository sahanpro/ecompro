<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductVariant extends Model { protected $fillable=['product_id','sku','size','color','material','price','stock_qty']; public function product(){return $this->belongsTo(Product::class);} public function stockMovements(){return $this->hasMany(StockMovement::class);} }
