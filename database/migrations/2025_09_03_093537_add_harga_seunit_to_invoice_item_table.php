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
        Schema::table('invoice_item', function (Blueprint $table) {
            $table->decimal('harga_seunit', 10, 2)->nullable()->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_item', function (Blueprint $table) {
            $table->dropColumn('harga_seunit');
        });
    }
};
