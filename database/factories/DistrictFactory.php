<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\District>
 */
class DistrictFactory extends Factory
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
            'map' => fake()->text(1000), // Long text for map data
            'population' => fake()->numberBetween(10000, 1000000),
            'city_id' => City::factory(),
        ];
    }
} 