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
        Schema::create('iklan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->string('nama_iklan');
            $table->text('keterangan')->nullable();
            $table->string('hari')->nullable();
            $table->boolean('on')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iklan');
    }
};
