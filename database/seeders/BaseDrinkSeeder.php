<?php

namespace Database\Seeders;

use App\Models\BaseDrink;
use Illuminate\Database\Seeder;

class BaseDrinkSeeder extends Seeder
{
    public function run(): void
    {
        BaseDrink::create([
            'name' => 'Americano',
            'bottle_capacity_ml' => 1200,
            'standard_serving_ml' => 150,
            'status' => 'Active',
        ]);

        BaseDrink::create([
            'name' => 'Kopi Susu',
            'bottle_capacity_ml' => 1200,
            'standard_serving_ml' => 120,
            'status' => 'Active',
        ]);

        BaseDrink::create([
            'name' => 'Kopi Susu Gula Aren',
            'bottle_capacity_ml' => 1200,
            'standard_serving_ml' => 120,
            'status' => 'Active',
        ]);
    }
}
