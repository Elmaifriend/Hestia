<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\VisitanteFactory> */
    use HasFactory;
    protected $fillable = ["codigo_id", "nombre", "apellido", "telefono", "correo"];

    public function codigo(){
        return $this->belongsTo(Codigo::class, "codigo_id");
    }
}
