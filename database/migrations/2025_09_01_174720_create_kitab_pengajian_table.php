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
        Schema::create('kitab_pengajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenaga_pengajar_id')->constrained('tenaga_pengajars')->onDelete('cascade');
            $table->string('gambar_kitab_rumi')->nullable();
            $table->string('gambar_kitab_jawi')->nullable();
            $table->string('nama_kitab');
            $table->string('link_kitab_rumi')->nullable();
            $table->string('link_kitab_jawi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitab_pengajian');
    }
};
