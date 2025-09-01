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
        Schema::create('jadual_pengajians', function (Blueprint $table) {
            $table->id();
            $table->string('hari')->nullable(); // Day
            $table->integer('minggu')->nullable(); // Week
            $table->string('masa')->nullable(); // Time
            $table->string('penceramah_program')->nullable(); // Speaker/Program
            $table->string('topik_kitab')->nullable(); // Topic/Book
            $table->string('tempat')->nullable(); // Place
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadual_pengajians');
    }
};
