<?php

namespace App\Imports;

use App\Models\JadualPengajian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadualPengajianImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new JadualPengajian([
            'hari' => $row['hari'] ?? null,
            'minggu' => isset($row['minggu']) && $row['minggu'] !== '' ? (int) $row['minggu'] : null,
            'masa' => $row['masa'] ?? null,
            'penceramah_program' => $row['penceramah_program'] ?? null,
            'topik_kitab' => $row['topik_kitab'] ?? null,
            'tempat' => $row['tempat'] ?? null,
        ]);
    }
}
