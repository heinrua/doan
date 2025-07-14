<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commune>
 */
class CommuneFactory extends Factory
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
            'district_id' => District::factory(),
        ];
    }
} 