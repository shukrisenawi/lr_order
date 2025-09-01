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
        Schema::create('pengajian', function (Blueprint $table) {
            $table->id();
            $table->string('hari')->nullable(); // Day
            $table->integer('minggu')->nullable(); // Week
            $table->string('masa')->nullable(); // Time
            $table->foreignId('pengajar_id')->constrained('tenaga_pengajars')->onDelete('cascade');
            $table->foreignId('kitab_id')->constrained('kitab_pengajian')->onDelete('cascade');
            $table->string('tempat')->nullable(); // Place
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajian');
    }
};
