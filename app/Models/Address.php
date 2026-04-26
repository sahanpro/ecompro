<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Address extends Model { protected $fillable=['user_id','type','line1','line2','city','state','postal_code','country','phone']; }
