<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Visitante;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Codigo>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "usuario_id" => User::inRandomOrder()->first()->id,
            "codigo" => fake()->uuid(),
            "asunto" => fake()->sentence(),
            "numero_visitantes" => fake()->randomDigitNotNull(),
            "entrada" => fake()->dateTimeBetween("-6 months"),
            "descripcion" => fake()->paragraph(2),
            "status" => "Pendiente",
        ];
    }
}
