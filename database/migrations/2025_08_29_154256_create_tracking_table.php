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
        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoice')->onDelete('set null');
            $table->string('kurier')->nullable()->default('J&T');
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('poskod', 10);
            $table->string('no_tel');
            $table->string('kandungan_parcel')->nullable();
            $table->string('jenis_parcel')->nullable();
            $table->string('berat')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('tinggi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking');
    }
};
