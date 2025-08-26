<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bisnes', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama_bisnes')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('nama_syarikat')->nullable();
            $table->string('no_pendaftaran')->nullable();
            $table->text('alamat')->nullable();
            $table->string('poskod', 10)->nullable();
            $table->string('no_tel')->nullable();
            $table->longText('system_message')->nullable();
            $table->boolean('on')->nullable()->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bisnes');
    }
};
