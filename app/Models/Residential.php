<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residential extends Model
{
    /** @use HasFactory<\Database\Factories\ResidentialFactory> */
    use HasFactory;

    protected $fillable = ["manager_id", "name", "address", "description"];

    public function manager(){
        return $this->belongsTo(User::class, "user_id");
    }
}
