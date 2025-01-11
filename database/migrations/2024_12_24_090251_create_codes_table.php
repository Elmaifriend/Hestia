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
            $table->unsignedBigInteger("user_id")->index();
            $table->string("code");
            $table->string("subject");
            $table->tinyInteger("visitors_number");
            $table->dateTime("scheduled");
            $table->dateTime("entry_check")->nullable();
            $table->datetime("exit_check")->nullable();
            $table->tinyText("description");
            $table->enum("status", [ "Pendiente", "Aprobado", "Terminado", "Cancelado" ] );
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
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
