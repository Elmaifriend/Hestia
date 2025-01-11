<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    /** @use HasFactory<\Database\Factories\AmenitiesFactory> */
    use HasFactory;

    protected $fillable = ["name", "description", "capacity"];
}
