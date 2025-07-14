<?php

namespace Database\Factories;

use App\Models\SubTypeOfCalamities;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncidentReport>
 */
class IncidentReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reporter_name' => fake()->name(),
            'contact_number' => fake()->phoneNumber(),
            'coordinates' => fake()->latitude() . ',' . fake()->longitude(),
            'description' => fake()->paragraph(),
            'attachment' => null,
            'sub_type_of_calamity_id' => SubTypeOfCalamities::factory(),
            'commune_id' => Commune::factory(),
        ];
    }
} 