<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Maintenance;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maintenance>
 */
class MaintenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = [ "En Revision", "Aceptado", "En Proceso", "Terminado", "Cancelado" ];

        return [
            "user_id" => User::inRandomOrder()->first()->id,
            "title" => fake()->paragraph(1),
            "description" => fake()->paragraph(),
            "status" => $status[array_rand($status)],
            "evidence" => null
        ];
    }
}
