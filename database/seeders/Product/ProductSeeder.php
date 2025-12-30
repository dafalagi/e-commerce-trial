<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create();

        for ($i = 1; $i <= 10; $i++) {
            Product::factory()->create([
                'stock' => rand(0, 10),
            ]);
        }
    }
}
