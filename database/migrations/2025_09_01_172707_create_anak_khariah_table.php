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
        Schema::create('anak_khariah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('gelaran')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->string('no_tel');
            $table->string('gambar')->nullable();
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->boolean('on')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_khariah');
    }
};
