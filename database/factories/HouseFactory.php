<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "residential_id" => 0,
            "owner_id" => 0,
            "house_number" => "#" . fake()->numberBetween(1, 10),
            "status" => "Habitada",
            "description" => fake()->paragraph()
        ];
    }
}
