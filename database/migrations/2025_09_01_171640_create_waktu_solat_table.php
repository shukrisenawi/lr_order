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
        Schema::create('waktu_solats', function (Blueprint $table) {
            $table->id();
            $table->date('tarikh');
            $table->string('tarikh_hijrah');
            $table->string('hari');
            $table->time('imsak');
            $table->time('subuh');
            $table->time('syuruk');
            $table->time('zohor');
            $table->time('asar');
            $table->time('maghrib');
            $table->time('isyak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_solats');
    }
};
