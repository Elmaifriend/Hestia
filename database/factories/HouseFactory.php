<?php

namespace Database\Factories;

use App\Models\Residential;
use App\Models\User;
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
            "residential_id" => Residential::inRandomOrder()->first()->id,
            "owner_id" => User::inRandomOrder()->first()->id,
            "house_number" => "#" . fake()->numberBetween(1, 200),
            "status" => "Habitada",
            "description" => fake()->paragraph()
        ];
    }
}
