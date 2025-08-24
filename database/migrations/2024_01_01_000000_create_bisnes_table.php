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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_bines');
            $table->date('exp_date')->nullable();
            $table->string('nama_syarikat');
            $table->text('alamat');
            $table->string('poskod', 10);
            $table->string('no_tel');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bisnes');
    }
};
