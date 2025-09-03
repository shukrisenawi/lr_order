<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KodCula;

class KodCulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kod_cula' => '1', 'nama_cula' => 'UMNO'],
            ['kod_cula' => '10', 'nama_cula' => 'PPBM'],
            ['kod_cula' => '11', 'nama_cula' => 'GERAKAN'],
            ['kod_cula' => '12', 'nama_cula' => 'PEJUANG'],
            ['kod_cula' => '13', 'nama_cula' => 'MCA'],
            ['kod_cula' => '14', 'nama_cula' => 'MIC'],
            ['kod_cula' => '15', 'nama_cula' => 'PUTRA'],
            ['kod_cula' => '16', 'nama_cula' => 'MUDA'],
            ['kod_cula' => '1A', 'nama_cula' => 'UMNO - SASARAN / LEMAH / ATAS PAGAR'],
            ['kod_cula' => '1B', 'nama_cula' => 'UMNO SOKONG PAS'],
            ['kod_cula' => '1P', 'nama_cula' => 'UMNO SOKONG PN (TIDAK SOKONG PAS)'],
            ['kod_cula' => '2', 'nama_cula' => 'PAS'],
            ['kod_cula' => '3', 'nama_cula' => 'PAS'],
            ['kod_cula' => '3B', 'nama_cula' => 'PAS LUAR KEDAH (BORNEO)'],
            ['kod_cula' => '3D', 'nama_cula' => 'PAS LUAR DUN'],
            ['kod_cula' => '3K', 'nama_cula' => 'PAS LUAR KEDAH (SEMENANJUNG)'],
            ['kod_cula' => '3M', 'nama_cula' => 'PAS LUAR MALAYSIA'],
            ['kod_cula' => '3P', 'nama_cula' => 'PAS LUAR PARLIMEN'],
            ['kod_cula' => '3U', 'nama_cula' => 'PAS LUAR UDM'],
            ['kod_cula' => '4', 'nama_cula' => 'ATAS PAGAR'],
            ['kod_cula' => '4P', 'nama_cula' => 'ATAS PAGAR SOKONG PN'],
            ['kod_cula' => '5', 'nama_cula' => 'PKR'],
            ['kod_cula' => '6', 'nama_cula' => 'DHPP'],
            ['kod_cula' => '7', 'nama_cula' => 'TIDAK DIKENALI'],
            ['kod_cula' => '7P', 'nama_cula' => 'TIDAK DIKENALI ( POLIS / TENTERA )'],
            ['kod_cula' => '8', 'nama_cula' => 'MATI'],
            ['kod_cula' => '9', 'nama_cula' => 'PAN DAP'],
            ['kod_cula' => '97', 'nama_cula' => 'LAIN-LAIN BANGSA'],
            ['kod_cula' => '98', 'nama_cula' => 'INDIA'],
            ['kod_cula' => '99', 'nama_cula' => 'CINA'],
            ['kod_cula' => '?', 'nama_cula' => 'BELUM DICULA'],
        ];

        foreach ($data as $item) {
            KodCula::updateOrCreate(
                ['kod_cula' => $item['kod_cula']],
                $item
            );
        }
    }
}
