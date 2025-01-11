<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\VisitanteFactory> */
    use HasFactory;
    protected $fillable = ["code_id", "name", "last_name", "phone_number", "email"];

    public function code(){
        return $this->belongsTo(Code::class, "code_id");
    }
}
