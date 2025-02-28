<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Code;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitante>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "last_name" => fake()->lastName(),
            "phone_number" => fake()->phoneNumber(),
            "email" => fake()->safeEmail(),
            "code_id" => Code::inRandomOrder()->first()->id
        ];
    }
}
