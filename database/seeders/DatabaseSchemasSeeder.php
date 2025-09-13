<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSchemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schemas = DB::select("SELECT table_name, column_name, data_type, is_nullable, column_default FROM information_schema.columns WHERE table_schema = DATABASE() ORDER BY table_name, ordinal_position");

        foreach ($schemas as $schema) {
            DB::table('database_schemas')->insert([
                'table_name' => $schema->table_name,
                'column_name' => $schema->column_name,
                'data_type' => $schema->data_type,
                'is_nullable' => $schema->is_nullable === 'YES' ? true : false,
                'column_default' => $schema->column_default,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
