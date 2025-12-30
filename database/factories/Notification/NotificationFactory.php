<?php

namespace Database\Factories\Notification;

use App\Enums\Notification\NotificationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification\Notification>
 */
class NotificationFactory extends Factory
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
            'title' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'type' => collect(NotificationType::cases())->random()->value,
            'is_read' => 0,

            'is_active' => 1,
            'version' => 0,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'deleted_at' => null,
        ];
    }
}
