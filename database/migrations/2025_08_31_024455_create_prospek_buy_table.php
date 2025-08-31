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
        Schema::create('prospek_buy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospek_alamat_id')->constrained('prospek_alamat')->onDelete('cascade');
            $table->decimal('harga', 10, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospek_buy');
    }
};
