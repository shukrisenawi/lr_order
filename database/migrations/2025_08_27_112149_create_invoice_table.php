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
            $table->string('invoice_id')->unique();
            $table->string('nama_penerima');
            $table->text('alamat');
            $table->string('no_tel');
            $table->string('jumlah');
            $table->string('status')->default('pending');
            $table->string('tracking_no');
            $table->string('kurier');
            $table->string('catatan');
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
