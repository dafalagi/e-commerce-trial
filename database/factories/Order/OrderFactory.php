<?php

namespace Database\Factories\Order;

use App\Enums\Order\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order\Order>
 */
class OrderFactory extends Factory
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
            'cart_id' => fake()->numberBetween(1, 10),
            'total_price' => fake()->randomFloat(2, 10, 1000),
            'payment_status' => collect(PaymentStatus::cases())->random()->value,

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
