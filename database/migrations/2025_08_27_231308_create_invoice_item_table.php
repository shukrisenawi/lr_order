<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained('invoice')->onDelete('cascade');
            $table->foreignId('produk_id')->nullable()->constrained('produk')->onDelete('cascade');
            $table->string('produk_custom')->nullable();
            $table->integer('kuantiti')->default(1);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_item');
    }
};
