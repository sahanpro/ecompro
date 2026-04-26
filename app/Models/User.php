<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable { use HasApiTokens, HasFactory; protected $fillable=['name','email','password','role','phone']; protected $hidden=['password','remember_token']; public function addresses():HasMany{return $this->hasMany(Address::class);} public function cart(){return $this->hasOne(Cart::class);} public function orders(){return $this->hasMany(Order::class);} public function wishlist(){return $this->hasMany(Wishlist::class);} }
