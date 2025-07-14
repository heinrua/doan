<?php

namespace Database\Factories;

use App\Models\TypeOfCalamities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubTypeOfCalamities>
 */
class SubTypeOfCalamitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement(['Sạt lở nhẹ', 'Sạt lở trung bình', 'Sạt lở nặng', 'Ngập lụt cục bộ', 'Ngập lụt diện rộng']);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'type_of_calamity_id' => TypeOfCalamities::factory(),
        ];
    }
} 