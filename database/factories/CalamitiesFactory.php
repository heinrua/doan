<?php

namespace Database\Factories;

use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calamities>
 */
class CalamitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence(3);
        return [
            'type_of_calamity_id' => TypeOfCalamities::factory(),
            'risk_level_id' => RiskLevel::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->address(),
            'length' => fake()->randomFloat(2, 1, 100),
            'width' => fake()->randomFloat(2, 1, 50),
            'acreage' => fake()->randomFloat(2, 1, 1000),
            'coordinates' => fake()->latitude() . ',' . fake()->longitude(),
            'map' => null,
            'image' => null,
            'video' => null,
            'time' => fake()->date(),
            'reason' => fake()->paragraph(),
            'geology' => fake()->paragraph(),
            'watermark_points' => fake()->paragraph(),
            'human_damage' => fake()->paragraph(),
            'property_damage' => fake()->paragraph(),
            'investment_level' => fake()->paragraph(),
            'mitigation_measures' => fake()->paragraph(),
            'support_policy' => fake()->paragraph(),
            'flood_level' => fake()->randomFloat(2, 1, 10),
            'flooded_area' => fake()->randomFloat(2, 1, 100),
            'flood_range' => fake()->paragraph(),
            'time_start' => fake()->date(),
            'time_end' => fake()->date(),
            'sprint_time' => fake()->paragraph(),
            'number_of_people_affected' => fake()->numberBetween(1, 1000),
            'damaged_infrastructure' => fake()->paragraph(),
            'data_source' => fake()->paragraph(),
        ];
    }
} 