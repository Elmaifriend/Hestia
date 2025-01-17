<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AmenityReservation extends Model
{
    /** @use HasFactory<\Database\Factories\AmenityReservationFactory> */
    use HasFactory;

    protected $fillable = [
                            "user_id",
                            "amenity_id",
                            "scheduled_entry_day",
                            "scheduled_entry_time",
                            "scheduled_exit_time",
                            "note"
                        ];


    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}

