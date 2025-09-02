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
        Schema::create('data_penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dm');
            $table->string('kod_lokaliti');
            $table->string('nama_lokaliti');
            $table->string('no_rumah')->nullable();
            $table->string('no_siri');
            $table->string('no_kp_baru');
            $table->string('no_kp_lama')->nullable();
            $table->string('nama_pemilih');
            $table->date('tarikh_lahir');
            $table->enum('jantina', ['L', 'P']);
            $table->string('bangsa');
            $table->string('kod_cula');
            $table->text('catatan')->nullable();
            $table->text('alamat_kp');
            $table->text('alamat_kediaman');
            $table->string('tel_rumah')->nullable();
            $table->string('tel_bimbit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_penduduk');
    }
};
