<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeOfCalamities>
 */
class TypeOfCalamitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['Sạt lở bờ sông', 'Ngập lụt', 'Bão', 'Lũ quét', 'Động đất', 'Sóng thần', 'Hạn hán', 'Cháy rừng']);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->sentence(),
        ];
    }
} 