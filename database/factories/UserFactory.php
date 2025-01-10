<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\usuario>
 */
class UserFactory extends Factory
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
            "cell_phone" => fake()->phoneNumber(),
            "email" => fake()->safeEmail(),
            "password" => Hash::make("contrasena"),
            "rol" => "Residente",
        ];
    }
}
