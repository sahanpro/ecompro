<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(['email' => 'admin@ecompro.test'], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Category::query()->firstOrCreate(['slug' => 'electronics'], ['name' => 'Electronics']);
        Brand::query()->firstOrCreate(['slug' => 'acme'], ['name' => 'Acme']);

        Coupon::query()->firstOrCreate(['code' => 'WELCOME10'], [
            'type' => 'percentage',
            'value' => 10,
            'min_cart_amount' => 100,
            'is_active' => true,
        ]);

        ShippingMethod::query()->firstOrCreate(['name' => 'Standard'], [
            'zone' => 'US',
            'type' => 'flat',
            'flat_rate' => 10,
            'eta_days' => 5,
            'is_active' => true,
        ]);
    }
}
