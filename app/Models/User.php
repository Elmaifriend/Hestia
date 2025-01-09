<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, HasApiTokens;
    protected $fillable = ["nombre", "apellido", "telefono", "rol", "correo", "contrasena" ];
    protected $hidden = ["contrasena"];

    public function codigos(){
        return $this->hasMany( Codigo::class, "usuario_id");
    }
}
