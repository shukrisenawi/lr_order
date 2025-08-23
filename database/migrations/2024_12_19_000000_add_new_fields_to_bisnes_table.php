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
        Schema::table('bisnes', function (Blueprint $table) {
            $table->string('no_pendaftaran')->after('nama_syarikat');
            $table->string('jenis_bisnes')->after('no_pendaftaran');
            $table->string('gambar')->nullable()->after('jenis_bisnes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bisnes', function (Blueprint $table) {
            $table->dropColumn(['no_pendaftaran', 'jenis_bisnes', 'gambar']);
        });
    }
};
