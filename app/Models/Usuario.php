<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, HasApiTokens;
    protected $fillable = ["nombre", "apellido", "telefono", "rol", "correo", "contrasena" ];

    public function codigos(){
        return $this->hasMany( Codigo::class, "usuario_id");
    }
}
