<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Codigo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitante>
 */
class VisitanteFactory extends Factory
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
            "codigo_id" => Codigo::inRandomOrder()->first()->id
        ];
    }
}
