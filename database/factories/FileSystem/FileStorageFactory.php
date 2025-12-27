<?php

namespace Database\Factories\FileSystem;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FileStorage\FileStorage>
 */
class FileStorageFactory extends Factory
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

            'size' => fake()->numberBetween(1000, 10000),
            'extension' => fake()->fileExtension(),
            'name' => fake()->unique()->word(),
            'original_name' => fake()->word(),
            'segment' => fake()->word(),
            'filesystem' => 'public',
            'location' => fake()->word(),
            'remark' => fake()->sentence(),
            'is_used' => 1,

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
