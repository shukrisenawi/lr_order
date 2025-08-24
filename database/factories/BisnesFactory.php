<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class BisnesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisBisnes = [
            'Kedai Runcit',
            'Restoran',
            'Kedai Pakaian',
            'Kedai Elektronik',
            'Klinik',
            'Salon Kecantikan',
            'Bengkel Kereta',
            'Kedai Makanan',
            'Pusat Latihan',
            'Kedai Buku',
            'Kedai Kasut',
            'Kedai Perabot',
            'Kedai Hardware',
            'Kedai Serbaneka',
            'Kedai Emas',
            'Kedai Telefon',
            'Kedai Komputer',
            'Kedai Basikal',
            'Kedai Alat Gim',
            'Kedai Mainan'
        ];

        return [
            'user_id' => User::factory(),
            'nama_bines' => fake()->company() . ' ' . fake()->companySuffix(),
            'exp_date' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
            'nama_syarikat' => fake()->company(),
            'no_pendaftaran' => 'SSM' . fake()->unique()->numerify('##########'),
            'jenis_bisnes' => fake()->randomElement($jenisBisnes),
            'gambar' => null,
            'alamat' => fake()->streetAddress() . ', ' . fake()->city() . ', ' . fake()->state(),
            'poskod' => fake()->postcode(),
            'no_tel' => fake()->phoneNumber(),
        ];
    }
}
