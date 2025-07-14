<?php

namespace Database\Factories;

use App\Models\TypeOfCalamities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiskLevel>
 */
class RiskLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement(['Thấp', 'Trung bình', 'Cao', 'Rất cao']);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->sentence(),
            'type_of_calamity_id' => TypeOfCalamities::factory(),
        ];
    }
} 