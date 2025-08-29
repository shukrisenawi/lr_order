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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->string('invoice_no')->unique();
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('no_tel');
            $table->string('jumlah');
            $table->string('status')->default('pending');
            $table->string('kurier')->nullable()->default('J&T');
            $table->string('catatan')->nullable();
            $table->boolean('create_by_ai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
