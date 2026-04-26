<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StockMovement extends Model { protected $fillable=['product_variant_id','change','reason','reference_type','reference_id']; }
