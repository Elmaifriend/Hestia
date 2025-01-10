<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, HasApiTokens;
    protected $fillable = ["name", "last_name", "cel_phone", "rol", "email", "password" ];
    protected $hidden = ["password"];

    public function codes(){
        return $this->hasMany( Code::class, "usuario_id");
    }
}
