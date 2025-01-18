<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Residential;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Residential>
 */
class ResidentialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "manager_id" => User::inRandomOrder()->first()->id,
            "name" => fake()->name(),
            "address" => fake()->address(),
            "description" => fake()->paragraph()
        ];
    }
}
