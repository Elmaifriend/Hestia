<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Amenity;
use App\Models\AmenityReservation;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Guest;
use App\Models\Code;
use App\Models\House;
use App\Models\Maintenance;
use App\Models\Resident;
use App\Models\Residential;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Create regular users ( Residents )
        User::factory(10)->create()->each(function(User $user){

            Code::factory(10)->create()->each(function(Code $code) use ( $user ){
                $code->user_id = $user->id;
                $code->save();

                Guest::factory()->create()->each(function( Guest $guest ) use ( $code ){
                    $guest->code_id = $code->id;
                    $guest->save();
                });

            });

        });


        //Creating Admin users
        User::factory(5)
            ->setAdminRole()
            ->create()->each(function(User $user){

            Code::factory(5)->create()->each(function(Code $code) use ( $user ){
                $code->user_id = $user->id;
                $code->save();

                Guest::factory()->create()->each(function( Guest $guest ) use ( $code ){
                    $guest->code_id = $code->id;
                    $guest->save();
                });
            });
        });


        //Creating Guard users
        User::factory(5)
            ->setGuardRole()
            ->create()->each(function(User $user){

            Code::factory(5)->create()->each(function(Code $code) use ( $user ){
                $code->user_id = $user->id;
                $code->save();

                Guest::factory()->create()->each(function( Guest $guest ) use ( $code ){
                    $guest->code_id = $code->id;
                    $guest->save();
                });
            });
        });


        //Create Staff users
        User::factory(5)
            ->setStaffRole()
            ->create()->each(function(User $user){

            Code::factory(5)->create()->each(function(Code $code) use ( $user ){
                $code->user_id = $user->id;
                $code->save();

                Guest::factory()->create()->each(function( Guest $guest ) use ( $code ){
                    $guest->code_id = $code->id;
                    $guest->save();
                });
            });
        });

        Residential::factory(10)->create();
        House::factory(1000)->create();
        Resident::factory(3000)->create();
        Maintenance::factory(4000)->create();
        Amenity::factory(10)->create();
        AmenityReservation::factory(1000)->create();

    }
}
