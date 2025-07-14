<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city();
        return [
            'name' => $name,
            'code' => fake()->unique()->regexify('[A-Z]{2}[0-9]{3}'),
            'slug' => Str::slug($name),
            'coordinates' => fake()->latitude() . ',' . fake()->longitude(),
        ];
    }
} 