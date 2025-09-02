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
        Schema::create('landing_page', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnes_id')->constrained('bisnes')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content'); // Rich text content
            $table->string('status')->default('draft'); // draft, published
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('template')->default('default'); // template type
            $table->json('settings')->nullable(); // additional settings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page');
    }
};
