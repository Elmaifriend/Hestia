<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Guest;

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
            "user_id" => User::inRandomOrder()->first()->id,
            "code" => fake()->uuid(),
            "subjec" => fake()->sentence(),
            "visitants_number" => fake()->randomDigitNotNull(),
            "entry" => fake()->dateTimeBetween("-6 months"),
            "description" => fake()->paragraph(2),
            "status" => "Pendiente",
        ];
    }
}
