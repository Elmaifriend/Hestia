<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Usuario;
use App\Models\Visitante;
use App\Models\Codigo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory(10)->create()->each(function(Usuario $usuario){

            Codigo::factory(10)->create()->each(function(Codigo $codigo) use ( $usuario ){
                $codigo->usuario_id = $usuario->id;

                Visitante::factory(1)->create()->each(function( Visitante $visitante ) use ( $codigo ){
                    $visitante->codigo_id = $codigo->id;
                });

            });

        });
    }
}
