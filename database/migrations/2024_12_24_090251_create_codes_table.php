<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("usuario_id")->index();
            $table->string("codigo");
            $table->string("asunto");
            $table->tinyInteger("numero_visitantes");
            $table->dateTime("entrada");
            $table->tinyText("descripcion");
            $table->enum("status", ["Aprobado", "Pendiente", "Cancelado" ] );
            $table->timestamps();

            $table->foreign("usuario_id")->references("id")->on("usuarios")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
