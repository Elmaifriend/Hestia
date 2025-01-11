<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    /** @use HasFactory<\Database\Factories\CodigoFactory> */
    use HasFactory;
    protected $fillable = ["user_id", "code", "subject", "visitors_number",
        "scheduled", "description", "status"];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function guests(){
        return $this->hasMany( Guest::class, "code_id" );
    }

    public function checkEntry( ){
        if( $this->status != "Aprobado" ){
            $this->status = "Aprobado";
            $this->save();
        }
    }

    public function checkExit(){
        if( $this->status != "Terminado"){
            $this->status = "Terminado";
            $this->save();
        }
    }
}
