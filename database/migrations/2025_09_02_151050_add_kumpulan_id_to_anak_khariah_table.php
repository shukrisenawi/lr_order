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
        Schema::table('anak_khariah', function (Blueprint $table) {
            $table->foreignId('kumpulan_id')->nullable()->constrained('kumpulan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anak_khariah', function (Blueprint $table) {
            $table->dropForeign(['kumpulan_id']);
            $table->dropColumn('kumpulan_id');
        });
    }
};
