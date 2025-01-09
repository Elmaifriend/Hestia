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
            "nombre" => fake()->name(),
            "apellido" => fake()->lastName(),
            "telefono" => fake()->phoneNumber(),
            "correo" => fake()->safeEmail(),
            "contrasena" => Hash::make("contrasena"),
            "rol" => "Residente",
        ];
    }
}
