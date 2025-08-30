<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prospek', function (Blueprint $table) {
            $table->id();
            $table->string('no_tel');
            $table->string('gelaran')->nullable();
            $table->string('session_id')->nullable();
            $table->string('status')->default('prospek');
            $table->foreignId('bisnes_id')->nullable()->constrained('bisnes')->onDelete('cascade');
            $table->boolean('on')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prospek');
    }
};
