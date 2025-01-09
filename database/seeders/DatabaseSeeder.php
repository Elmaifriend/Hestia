<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Guest;
use App\Models\Code;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function(User $user){

            Code::factory(10)->create()->each(function(Code $code) use ( $user ){
                $code->user_id = $user->id;

                Guest::factory(1)->create()->each(function( Guest $guest ) use ( $code ){
                    $guest->code_id = $code->id;
                });

            });

        });
    }
}
