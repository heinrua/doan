<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrative>
 */
class AdministrativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $district = District::factory()->create();
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
        return [
            'name' => fake()->company(),
            'type' => fake()->randomElement(['school', 'medical', 'center']),
            'code' => fake()->unique()->regexify('[A-Z]{2}[0-9]{3}'),
            'address' => fake()->address(),
            'coordinates' => fake()->latitude() . ',' . fake()->longitude(),
            'description' => fake()->text(200),
            'classify' => fake()->word(),
            'commune_id' => $commune->id,
            'population' => fake()->numberBetween(100, 5000),
        ];
    }
} 