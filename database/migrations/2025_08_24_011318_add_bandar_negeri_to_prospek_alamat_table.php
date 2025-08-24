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
        Schema::table('prospek_alamat', function (Blueprint $table) {
            $table->string('bandar')->nullable()->after('alamat');
            $table->string('negeri')->nullable()->after('bandar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prospek_alamat', function (Blueprint $table) {
            $table->dropColumn(['bandar', 'negeri']);
        });
    }
};
