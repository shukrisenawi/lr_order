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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->string('whatsapp_id')->nullable();
            $table->string('gelaran')->nullable();
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('poskod', 10);
            $table->string('no_tel');
            $table->string('email')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
