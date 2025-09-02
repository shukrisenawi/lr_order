<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WaktuSolat;

class WaktuSolatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data from database and seed it
        $existingData = WaktuSolat::all();

        if ($existingData->isEmpty()) {
            // If no data exists, seed with sample data for 2025
            $sampleData = [
                [
                    'tarikh' => '2025-01-01',
                    'tarikh_hijrah' => '01-Rej-1446',
                    'hari' => 'Rabu',
                    'imsak' => '06:05:00',
                    'subuh' => '06:15:00',
                    'syuruk' => '07:25:00',
                    'zohor' => '13:24:00',
                    'asar' => '16:44:00',
                    'maghrib' => '19:16:00',
                    'isyak' => '20:30:00',
                ],
                [
                    'tarikh' => '2025-01-02',
                    'tarikh_hijrah' => '02-Rej-1446',
                    'hari' => 'Khamis',
                    'imsak' => '06:05:00',
                    'subuh' => '06:15:00',
                    'syuruk' => '07:26:00',
                    'zohor' => '13:24:00',
                    'asar' => '16:45:00',
                    'maghrib' => '19:16:00',
                    'isyak' => '20:31:00',
                ],
                [
                    'tarikh' => '2025-01-03',
                    'tarikh_hijrah' => '03-Rej-1446',
                    'hari' => 'Jumaat',
                    'imsak' => '06:06:00',
                    'subuh' => '06:16:00',
                    'syuruk' => '07:26:00',
                    'zohor' => '13:25:00',
                    'asar' => '16:45:00',
                    'maghrib' => '19:17:00',
                    'isyak' => '20:31:00',
                ],
                [
                    'tarikh' => '2025-12-31',
                    'tarikh_hijrah' => '10-Rej-1447',
                    'hari' => 'Rabu',
                    'imsak' => '06:04:00',
                    'subuh' => '06:14:00',
                    'syuruk' => '07:25:00',
                    'zohor' => '13:23:00',
                    'asar' => '16:44:00',
                    'maghrib' => '19:15:00',
                    'isyak' => '20:30:00',
                ],
            ];

            WaktuSolat::insert($sampleData);
        } else {
            // If data already exists, we can optionally update or skip
            $this->command->info('Waktu Solat data already exists in database. Skipping seeder.');
        }
    }
}
