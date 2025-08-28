<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BisnesType;

class BisnesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BisnesType::Create(
            [
                'id' => 1,
                'type' => 'Produk'
            ]
        );
        BisnesType::Create(
            [
                'id' => 2,
                'type' => 'Masjid Batu 5'
            ]
        );
    }
}
