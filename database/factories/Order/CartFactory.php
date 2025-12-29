<?php

namespace Database\Factories\Order;

use App\Enums\Order\CartStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order\Cart>
 */
class CartFactory extends Factory
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

            'user_id' => fake()->numberBetween(1, 10),
            'status' => collect(CartStatus::cases())->random()->value,
            'total_price' => fake()->randomFloat(2, 10, 1000),

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
