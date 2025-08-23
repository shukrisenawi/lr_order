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
        Schema::create('bisnes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_bines');
            $table->string('exp_date')->nullable();
            $table->string('nama_syarikat');
            $table->string('alamat');
            $table->integer('poskod');
            $table->string('no_tel');
            $table->timestamps();
        });

        Schema::create('prospek', function (Blueprint $table) {
            $table->id();
            $table->string('no_tel');
            $table->string('gelaran')->nullable();
            $table->string('status')->default('prospek');
            $table->foreignId('bisnes_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('prospek_alamat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospek_id')->constrained()->onDelete('cascade');
            $table->string('nama_penerima');
            $table->string('alamat');
            $table->integer('poskod');
            $table->string('no_tel');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        Schema::create('prospek_buy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospek_alamat_id')->constrained()->onDelete('cascade');
            $table->integer('kuantiti');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->timestamps();
        });

        Schema::create('gambar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fail');
            $table->text('gambar')->nullable();
            $table->text('link_gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
        Schema::dropIfExists('prospek_buy');
        Schema::dropIfExists('prospek_alamat');
        Schema::dropIfExists('prospek');
        Schema::dropIfExists('bisnes');
    }
};
