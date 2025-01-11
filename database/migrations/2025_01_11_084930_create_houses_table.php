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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("residential_id")->index();
            $table->unsignedBigInteger("owner_id")->index();
            $table->string("house_number");
            $table->enum("status", ["Disponible", "Mantenimiento", "Habitada"]);
            $table->string("description");
            $table->timestamps();

            $table->foreign("residential_id")->references("id")->on("residentials")->cascadeOnDelete();
            $table->foreign("owner_id")->references("id")->on("users")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
