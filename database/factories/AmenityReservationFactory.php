<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AmenityReservation>
 */
class AmenityReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTime("+3 months");
        $entry_time = fake()->time();

        return [
            "user_id" => 0,
            "amenity_id" => 0,
            "scheduled_entry_day" => $date,
            "scheduled_entry_time" => $entry_time,
            "scheduled_exit_time" => fake()->time($entry_time, "+2 hours"),
            "note" => fake()->paragraph()
        ];
    }
}

