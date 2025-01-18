<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, HasApiTokens;
    protected $fillable = ["name", "last_name", "phone_number", "role", "email", "password" ];
    protected $hidden = ["password"];

    public function codes(){
        return $this->hasMany( Code::class, "user_id");
    }

    public function residentials(){
        return $this->hasMany(Residential::class, "user_id");
    }

    public function resident(){
        return $this->hasOne(Resident::class, "user_id");
    }

    public function maintenanceRequests(){
        return $this->hasMany(Maintenance::class, "user_id");
    }

    public function amenitiesReservations(){
        return $this->hasMany(AmenityReservation::class, "user_id");
    }
}
