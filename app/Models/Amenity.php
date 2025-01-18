<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\AmenitiesFactory> */
    use HasFactory;

    protected $fillable = ["name", "description", "capacity"];

    public function reservations(){
        return $this->hasMany(AmenityReservation::class, "amenity_id");
    }
}
