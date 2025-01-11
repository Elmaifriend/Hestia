<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;

    protected $fillable = ["user_id", "title", "description", "status", "evidence"];

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }
}
