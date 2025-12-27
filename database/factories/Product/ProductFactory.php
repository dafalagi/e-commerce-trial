<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),

            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 1000),
            'stock' => fake()->numberBetween(20, 100),

            'is_active' => 1,
            'version' => 0,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'created_at' => now()->timestamp,
            'updated_at' => null,
            'deleted_at' => null,
        ];
    }
}
