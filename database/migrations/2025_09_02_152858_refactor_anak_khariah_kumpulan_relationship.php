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
        // Drop the kumpulan_id column from anak_khariah
        Schema::table('anak_khariah', function (Blueprint $table) {
            $table->dropForeign(['kumpulan_id']);
            $table->dropColumn('kumpulan_id');
        });

        // Create pivot table for many-to-many relationship
        Schema::create('anak_khariah_kumpulan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_khariah_id')->constrained('anak_khariah')->onDelete('cascade');
            $table->foreignId('kumpulan_id')->constrained('kumpulan')->onDelete('cascade');
            $table->timestamps();

            // Ensure unique combination
            $table->unique(['anak_khariah_id', 'kumpulan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop pivot table
        Schema::dropIfExists('anak_khariah_kumpulan');

        // Add back kumpulan_id column to anak_khariah
        Schema::table('anak_khariah', function (Blueprint $table) {
            $table->foreignId('kumpulan_id')->nullable()->constrained('kumpulan')->onDelete('set null');
        });
    }
};
