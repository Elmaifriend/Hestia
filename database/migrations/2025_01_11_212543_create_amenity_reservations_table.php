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
        Schema::create('amenity_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("amenity_id")->index();
            $table->date("scheduled_entry_day");
            $table->time("scheduled_entry_time");
            $table->time("scheduled_exit_time");
            $table->string("note");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("amenity_id")->references("id")->on("users")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_reservations');
    }
};
