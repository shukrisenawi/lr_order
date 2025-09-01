<?php

namespace App\Imports;

use App\Models\WaktuSolat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class WaktuSolatImport implements ToModel, WithHeadingRow
{
    /**
     * Convert Excel date serial number to date format
     */
    private function convertExcelDate($excelDate)
    {
        if (!$excelDate || !is_numeric($excelDate)) {
            return null;
        }

        try {
            // Excel date serial number starts from 1900-01-01
            $unixTimestamp = ($excelDate - 25569) * 86400; // 25569 is days from 1900-01-01 to 1970-01-01
            return Carbon::createFromTimestamp($unixTimestamp)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert Excel time fraction to time format
     */
    private function convertExcelTime($excelTime)
    {
        if (!$excelTime || !is_numeric($excelTime)) {
            return null;
        }

        try {
            // Excel time is stored as fraction of a day
            $totalSeconds = $excelTime * 86400; // Convert to seconds
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = floor($totalSeconds % 60);

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new WaktuSolat([
            'tarikh' => $this->convertExcelDate($row['tarikh'] ?? null),
            'tarikh_hijrah' => $row['tarikh_hijrah'] ?? null,
            'hari' => $row['hari'] ?? null,
            'imsak' => $this->convertExcelTime($row['imsak'] ?? null),
            'subuh' => $this->convertExcelTime($row['subuh'] ?? null),
            'syuruk' => $this->convertExcelTime($row['syuruk'] ?? null),
            'zohor' => $this->convertExcelTime($row['zohor'] ?? null),
            'asar' => $this->convertExcelTime($row['asar'] ?? null),
            'maghrib' => $this->convertExcelTime($row['maghrib'] ?? null),
            'isyak' => $this->convertExcelTime($row['isyak'] ?? null),
        ]);
    }
}
