<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "house_id" => House::inRandomOrder()->first(),
            "user_id" => User::inRandomOrder()->first(),
            "ownership" => "Propietario",
            "status" => "Activo"
        ];
    }
}
