<?php

namespace App\Imports;

use App\Models\DataPenduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class DataPendudukImport implements ToModel, WithHeadingRow
{
    /**
     * Map various possible column names to standard names
     */
    private function mapColumnNames(array $row): array
    {
        $mapped = [];

        // Define possible column name variations - updated to match your Excel headers
        $columnMappings = [
            'nama_dm' => ['nama_dm', 'nama dm', 'nama-dm', 'dm', 'nama_dm_padang', 'Nama DM'],
            'kod_lokaliti' => ['kod_lokaliti', 'kod lokaliti', 'kod-lokaliti', 'kod_lok', 'kod', 'Kod Lokaliti'],
            'nama_lokaliti' => ['nama_lokaliti', 'nama lokaliti', 'nama-lokaliti', 'nama_lok', 'lokaliti', 'Nama Lokaliti'],
            'no_rumah' => ['no_rumah', 'no rumah', 'no-rumah', 'rumah', 'No. Rumah'],
            'no_siri' => ['no_siri', 'no siri', 'no-siri', 'siri', 'No. Siri'],
            'no_kp_baru' => ['no_kp_baru', 'no kp baru', 'no-kp-baru', 'kp_baru', 'ic_baru', 'ic baru', 'No. K/P (Baru)'],
            'no_kp_lama' => ['no_kp_lama', 'no kp lama', 'no-kp-lama', 'kp_lama', 'ic_lama', 'ic lama', 'No. K/P (Lama)'],
            'nama_pemilih' => ['nama_pemilih', 'nama pemilih', 'nama-pemilih', 'nama', 'pemilih', 'Nama Pemilih'],
            'tarikh_lahir' => ['tarikh_lahir', 'tarikh lahir', 'tarikh-lahir', 'lahir', 'dob', 'date_of_birth', 'Tarikh Lahir'],
            'jantina' => ['jantina', 'gender', 'sex', 'j', 'Jantina'],
            'bangsa' => ['bangsa', 'race', 'ethnicity', 'b', 'Bangsa'],
            'kod_cula' => ['kod_cula', 'kod cula', 'kod-cula', 'cula', 'kod_c', 'Kod Cula'],
            'catatan' => ['catatan', 'note', 'remark', 'comments', 'Catatan'],
            'alamat_kp' => ['alamat_kp', 'alamat kp', 'alamat-kp', 'alamat_kampung', 'kampung', 'Alamat K/P'],
            'alamat_kediaman' => ['alamat_kediaman', 'alamat kediaman', 'alamat-kediaman', 'alamat', 'address', 'Alamat Kediaman'],
            'tel_rumah' => ['tel_rumah', 'tel rumah', 'tel-rumah', 'phone', 'telephone', 'Tel. Rumah'],
            'tel_bimbit' => ['tel_bimbit', 'tel bimbit', 'tel-bimbit', 'mobile', 'hp', 'handphone', 'Tel. Bimbit'],
        ];

        foreach ($columnMappings as $standardName => $possibleNames) {
            foreach ($possibleNames as $possibleName) {
                if (isset($row[$possibleName])) {
                    $mapped[$standardName] = $this->cleanData($row[$possibleName]);
                    break;
                }
            }
        }

        return $mapped;
    }

    /**
     * Clean data by removing unwanted characters like = and quotes
     */
    private function cleanData($value)
    {
        if (empty($value)) {
            return '';
        }

        $value = trim($value);

        // Remove leading = and surrounding quotes
        if (str_starts_with($value, '="') && str_ends_with($value, '"')) {
            $value = substr($value, 2, -1);
        } elseif (str_starts_with($value, '=')) {
            $value = substr($value, 1);
        }

        // Remove surrounding quotes if they exist
        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            $value = substr($value, 1, -1);
        }

        return trim($value);
    }

    /**
     * Parse date from various formats including Excel serial numbers
     */
    private function parseDate($dateValue)
    {
        if (empty($dateValue) || trim($dateValue) === '') {
            return '1970-01-01'; // Default date
        }

        $dateValue = trim($dateValue);

        try {
            // Handle Excel serial date numbers (like 30782)
            if (is_numeric($dateValue)) {
                $serial = (int) $dateValue;
                if ($serial > 0 && $serial < 100000) { // Reasonable range for Excel dates
                    // Excel serial date starts from 1900-01-01
                    $unixTimestamp = ($serial - 25569) * 86400; // 25569 is days from 1900-01-01 to 1970-01-01
                    return date('Y-m-d', $unixTimestamp);
                }
            }

            // Try to parse as regular date string
            $parsed = \Carbon\Carbon::parse($dateValue);
            return $parsed->format('Y-m-d');

        } catch (\Exception $e) {
            Log::warning('DataPenduduk Import: Failed to parse date, using default', [
                'original_value' => $dateValue,
                'error' => $e->getMessage()
            ]);
            return '1970-01-01'; // Default date if parsing fails
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Map column names to standard format
        $mappedRow = $this->mapColumnNames($row);

        // Debug: Log the original and mapped row data
        Log::info('DataPenduduk Import Original Row:', $row);
        Log::info('DataPenduduk Import Mapped Row:', $mappedRow);

        // More flexible validation - only skip if critical fields are missing
        if (empty($this->cleanData($mappedRow['nama_dm'])) || empty($this->cleanData($mappedRow['nama_pemilih'])) || empty($this->cleanData($mappedRow['no_kp_baru']))) {
            Log::warning('DataPenduduk Import: Skipping row due to missing critical fields (nama_dm, nama_pemilih, no_kp_baru)', $mappedRow);
            return null; // Skip this row
        }

        // Provide defaults for other fields if they're empty
        if (empty($mappedRow['kod_lokaliti'])) $mappedRow['kod_lokaliti'] = '';
        if (empty($mappedRow['nama_lokaliti'])) $mappedRow['nama_lokaliti'] = '';
        if (empty($mappedRow['no_siri'])) $mappedRow['no_siri'] = '';
        if (empty($mappedRow['alamat_kp']) && empty($mappedRow['alamat_kediaman'])) {
            $mappedRow['alamat_kp'] = '';
            $mappedRow['alamat_kediaman'] = '';
        } elseif (empty($mappedRow['alamat_kp'])) {
            $mappedRow['alamat_kp'] = $this->cleanData($mappedRow['alamat_kediaman']);
        } elseif (empty($mappedRow['alamat_kediaman'])) {
            $mappedRow['alamat_kediaman'] = $this->cleanData($mappedRow['alamat_kp']);
        }
        if (empty($mappedRow['tel_bimbit'])) $mappedRow['tel_bimbit'] = '';

        $data = [
            'nama_dm' => $this->cleanData($mappedRow['nama_dm']) ?: '',
            'kod_lokaliti' => $this->cleanData($mappedRow['kod_lokaliti']) ?: '',
            'nama_lokaliti' => $this->cleanData($mappedRow['nama_lokaliti']) ?: '',
            'no_rumah' => !empty($this->cleanData($mappedRow['no_rumah'] ?? '')) ? $this->cleanData($mappedRow['no_rumah']) : null,
            'no_siri' => $this->cleanData($mappedRow['no_siri']) ?: '',
            'no_kp_baru' => $this->cleanData($mappedRow['no_kp_baru']) ?: '',
            'no_kp_lama' => !empty($this->cleanData($mappedRow['no_kp_lama'] ?? '')) ? $this->cleanData($mappedRow['no_kp_lama']) : null,
            'nama_pemilih' => $this->cleanData($mappedRow['nama_pemilih']) ?: '',
            'tarikh_lahir' => $this->parseDate($mappedRow['tarikh_lahir'] ?? null),
            'jantina' => $this->cleanData($mappedRow['jantina'] ?? 'L'), // Default to 'L' (Lelaki)
            'bangsa' => $this->cleanData($mappedRow['bangsa'] ?? 'M'), // Default to 'M' (Melayu)
            'kod_cula' => $this->cleanData($mappedRow['kod_cula'] ?? '99'), // Default to '99'
            'catatan' => !empty($this->cleanData($mappedRow['catatan'] ?? '')) ? $this->cleanData($mappedRow['catatan']) : null,
            'alamat_kp' => $this->cleanData($mappedRow['alamat_kp']) ?: '',
            'alamat_kediaman' => $this->cleanData($mappedRow['alamat_kediaman']) ?: '',
            'tel_rumah' => !empty($this->cleanData($mappedRow['tel_rumah'] ?? '')) ? $this->cleanData($mappedRow['tel_rumah']) : null,
            'tel_bimbit' => $this->cleanData($mappedRow['tel_bimbit']) ?: '',
        ];

        Log::info('DataPenduduk Import: Processing row successfully', [
            'nama_pemilih' => $data['nama_pemilih'],
            'no_kp_baru' => $data['no_kp_baru'],
            'tel_bimbit' => $data['tel_bimbit'],
            'processed_data' => $data
        ]);

        return new DataPenduduk($data);
    }
}
