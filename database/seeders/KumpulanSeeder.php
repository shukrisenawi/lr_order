<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kumpulan;

class KumpulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'AJK Masjid',
            'Ribat Abu AL-Hassan',
            'Usrah Bukit',
            'Muslimat Masjid'
        ];

        foreach ($groups as $group) {
            Kumpulan::create([
                'nama' => $group,
                'description' => null,
                'bisnes_id' => 3,
                'on' => true,
            ]);
        }

        $this->command->info('Kumpulan seeder berjaya dijalankan!');
        $this->command->info('Jumlah kumpulan: ' . Kumpulan::count());
    }
}
