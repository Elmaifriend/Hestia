<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    /** @use HasFactory<\Database\Factories\HouseFactory> */
    use HasFactory;

    protected $fillable = ["residential_id", "owner_id", "house_numer", "status", "description"];


    public function residential(){
        return $this->belongsTo(Residential::class, "residential_id");
    }

    public function residents(){
        return $this->hasMany(Resident::class, "house_id");
    }
}
