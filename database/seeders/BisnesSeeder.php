<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bisnes;
use App\Models\User;

class BisnesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan user yang sudah ada dari UserSeeder
        $user = User::where('email', 'shukrisenawi@gmail.com')->first();
        
        // if ($user) {
            // Buat 5 bisnis untuk user shukrisenawi
            // Bisnes::factory()->count(5)->create([
            //     'user_id' => $user->id,
            // ]);
        // }

        // Buat 10 bisnis tambahan untuk user random
        // Bisnes::factory()->count(10)->create();
        
        // Buat beberapa bisnis dengan data spesifik
        Bisnes::create([
            'user_id' => $user ? $user->id : User::factory()->create()->id,
            'nama_bines' => 'StickerTermurah',
            'exp_date' => '2025-09-16',
            'nama_syarikat' => 'SH BEST CREATIVE DESIGN',
            'no_pendaftaran' => 'KC0035097-W',
            'jenis_bisnes' => 'Printing',
            'gambar' => 'y5L9ZbhoWyUW70mS9G3Xi9wXF9R72aolld3j50lS.png',
            'alamat' => 'No 1 Simpang 3 Beris Jaya, 08200 Sik, Kedah',
            'poskod' => '08200',
            'no_tel' => '016-6831403',
        ]);

        Bisnes::create([
            'user_id' => $user ? $user->id : User::factory()->create()->id,
            'nama_bines' => 'Jamu Asli',
            'exp_date' => null,
            'nama_syarikat' => 'Jamu Asli',
            'no_pendaftaran' => '',
            'jenis_bisnes' => 'Ubatan Tradisional',
            'gambar' => 'djH92xh5RxmwtfcUMf4hSGB2GoDCVYUFPxk4FVNw.png',
            'alamat' => 'No 17222 Kg Kuala Teloi Batu 5, 08200 Sik, Kedah',
            'poskod' => '08200',
            'no_tel' => '010-6679670',
        ]);

        $this->command->info('Bisnes seeder berjaya dijalankan!');
        $this->command->info('Jumlah bisnis: ' . Bisnes::count());
    }
}
