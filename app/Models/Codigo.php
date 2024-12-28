<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    /** @use HasFactory<\Database\Factories\CodigoFactory> */
    use HasFactory;
    protected $fillable = ["usuario_id", "codigo", "asunto", "numero_visitantes",
        "entrada", "descripcion", "status"];

    public function usuario(){
        return $this->belongsTo(Usuario::class, "usuario_id");
    }

    public function visitantes(){
        return $this->hasMany( Visitante::class, "codigo_id" );
    }

    public function aprobar( ){
        if( $this->status != "Aprobado" ){
            $this->status = "Aprobado";
            $this->save();
        }
    }
}
