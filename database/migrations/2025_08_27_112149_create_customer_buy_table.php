<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_buy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_alamat_id')->nullable()->constrained('customer_alamat')->onDelete('cascade');
            $table->foreignId('produk_id')->nullable()->constrained('produk')->onDelete('cascade');
            $table->string('produk_custom')->nullable();
            $table->integer('kuantiti')->default(1);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_buy');
    }
};
