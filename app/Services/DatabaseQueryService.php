<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class DatabaseQueryService
{
    protected $allowedTables = [
        'bisnes',
        'customer',
        'invoice',
        'invoice_item',
        'produk',
        'prospek',
        'gambar',
        'iklan',
        'tracking',
        'jadual_pengajian',
        'waktu_solat',
        'anak_khariah',
        'tenaga_pengajar',
        'kitab_pengajian',
        'pengajian',
        'data_penduduk',
        'program',
        'pengumuman',
        'landing_page',
        'kumpulan',
        'kod_cula'
    ];

    protected $tableDescriptions = [
        'bisnes' => 'Business/company information including name, registration, address, and contact details',
        'customer' => 'Customer data including names, addresses, phone numbers, and contact information',
        'invoice' => 'Invoice records with customer details, amounts, status, and courier information',
        'invoice_item' => 'Individual items within invoices including product details and pricing',
        'produk' => 'Product catalog with names, descriptions, and pricing information',
        'prospek' => 'Prospect/lead information for potential customers',
        'gambar' => 'Image/file storage information',
        'iklan' => 'Advertisement campaign data',
        'tracking' => 'Tracking information for shipments or activities',
        'jadual_pengajian' => 'Study schedule/timetable information',
        'waktu_solat' => 'Prayer time schedules',
        'anak_khariah' => 'Student/learner information',
        'tenaga_pengajar' => 'Teacher/instructor information',
        'kitab_pengajian' => 'Study materials/books information',
        'pengajian' => 'Study session records',
        'data_penduduk' => 'Population/demographic data',
        'program' => 'Program/event information',
        'pengumuman' => 'Announcement/notification data',
        'landing_page' => 'Website landing page information',
        'kumpulan' => 'Group/category information',
        'kod_cula' => 'Area/region code information'
    ];

    public function getDatabaseSchema()
    {
        $schema = [];

        foreach ($this->allowedTables as $table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                $schema[$table] = [
                    'description' => $this->tableDescriptions[$table] ?? 'Table data',
                    'columns' => $columns
                ];
            }
        }

        return $schema;
    }

    public function executeSafeQuery($sql, $bindings = [])
    {
        // Validate that this is a SELECT query only
        $upperSql = strtoupper(trim($sql));
        if (!str_starts_with($upperSql, 'SELECT')) {
            throw new \Exception('Only SELECT queries are allowed for security reasons.');
        }

        // Remove dangerous keywords
        $dangerousPatterns = [
            '/\b(INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|TRUNCATE|EXEC|EXECUTE)\b/i',
            '/\b(UNION\s+SELECT|UNION\s+ALL)/i',
            '/;\s*(INSERT|UPDATE|DELETE|DROP|CREATE|ALTER)/i'
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $sql)) {
                throw new \Exception('Query contains potentially dangerous operations.');
            }
        }

        try {
            $result = DB::select($sql, $bindings);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Database query error: ' . $e->getMessage());
        }
    }

    public function generateQueryFromNaturalLanguage($query)
    {
        $query = strtolower($query);

        // Pattern 1: Count queries
        if ($this->isCountQuery($query)) {
            return $this->handleCountQuery($query);
        }

        // Pattern 2: List queries
        if ($this->isListQuery($query)) {
            return $this->handleListQuery($query);
        }

        // Pattern 3: Search queries
        if ($this->isSearchQuery($query)) {
            return $this->handleSearchQuery($query);
        }

        // Pattern 4: Status queries
        if ($this->isStatusQuery($query)) {
            return $this->handleStatusQuery($query);
        }

        // Pattern 5: Summary queries
        if ($this->isSummaryQuery($query)) {
            return $this->handleSummaryQuery($query);
        }

        return null; // No matching pattern found
    }

    private function isCountQuery($query)
    {
        $countKeywords = ['berapa banyak', 'jumlah', 'berapa orang', 'berapa buah', 'total', 'count'];
        foreach ($countKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function handleCountQuery($query)
    {
        if (strpos($query, 'pelanggan') !== false || strpos($query, 'customer') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM customer',
                'description' => 'Jumlah pelanggan dalam sistem'
            ];
        }

        if (strpos($query, 'bisnes') !== false || strpos($query, 'perniagaan') !== false || strpos($query, 'syarikat') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM bisnes',
                'description' => 'Jumlah perniagaan dalam sistem'
            ];
        }

        if (strpos($query, 'invoice') !== false || strpos($query, 'invois') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM invoice',
                'description' => 'Jumlah invois dalam sistem'
            ];
        }

        if (strpos($query, 'produk') !== false || strpos($query, 'product') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM produk',
                'description' => 'Jumlah produk dalam sistem'
            ];
        }

        if (strpos($query, 'prospek') !== false || strpos($query, 'prospect') !== false || strpos($query, 'leads') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM prospek',
                'description' => 'Jumlah prospek dalam sistem'
            ];
        }

        return null;
    }

    private function isListQuery($query)
    {
        $listKeywords = ['senarai', 'list', 'tunjukkan', 'paparkan', 'show', 'nama'];
        foreach ($listKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function handleListQuery($query)
    {
        if (strpos($query, 'pelanggan') !== false || strpos($query, 'customer') !== false) {
            return [
                'sql' => 'SELECT nama_penerima, no_tel, email, alamat FROM customer ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 pelanggan terkini'
            ];
        }

        if (strpos($query, 'produk') !== false || strpos($query, 'product') !== false) {
            return [
                'sql' => 'SELECT nama, harga, deskripsi FROM produk ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 produk terkini'
            ];
        }

        if (strpos($query, 'invoice') !== false || strpos($query, 'invois') !== false) {
            return [
                'sql' => 'SELECT invoice_no, nama_penerima, jumlah, status FROM invoice ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 invois terkini'
            ];
        }

        if (strpos($query, 'bisnes') !== false || strpos($query, 'perniagaan') !== false || strpos($query, 'syarikat') !== false) {
            return [
                'sql' => 'SELECT nama_bisnes, nama_syarikat, no_tel FROM bisnes ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 bisnes terkini'
            ];
        }

        if (strpos($query, 'prospek') !== false || strpos($query, 'prospect') !== false || strpos($query, 'leads') !== false) {
            return [
                'sql' => 'SELECT gelaran, no_tel, status, created_at FROM prospek ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 prospek terkini'
            ];
        }

        return null;
    }

    private function isSearchQuery($query)
    {
        $searchKeywords = ['cari', 'find', 'search', 'carian'];
        foreach ($searchKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function handleSearchQuery($query)
    {
        // Extract search term
        $searchTerm = $this->extractSearchTerm($query);

        if (!$searchTerm) {
            return null;
        }

        if (strpos($query, 'pelanggan') !== false || strpos($query, 'customer') !== false) {
            return [
                'sql' => 'SELECT nama_penerima, no_tel, email, alamat FROM customer WHERE nama_penerima LIKE ? OR no_tel LIKE ? OR email LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian pelanggan untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'produk') !== false || strpos($query, 'product') !== false) {
            return [
                'sql' => 'SELECT nama, harga, deskripsi FROM produk WHERE nama LIKE ? OR deskripsi LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian produk untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'prospek') !== false || strpos($query, 'prospect') !== false || strpos($query, 'leads') !== false) {
            return [
                'sql' => 'SELECT gelaran, no_tel, status FROM prospek WHERE gelaran LIKE ? OR no_tel LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian prospek untuk: '$searchTerm'"
            ];
        }

        return null;
    }

    private function extractSearchTerm($query)
    {
        // Simple extraction - look for quoted terms or words after search keywords
        if (preg_match('/["\']([^"\']+)["\']/', $query, $matches)) {
            return $matches[1];
        }

        // Look for words after search keywords
        $searchKeywords = ['cari', 'find', 'search', 'untuk'];
        foreach ($searchKeywords as $keyword) {
            $pos = strpos($query, $keyword);
            if ($pos !== false) {
                $afterKeyword = substr($query, $pos + strlen($keyword));
                $words = explode(' ', trim($afterKeyword));
                return $words[0] ?? null;
            }
        }

        return null;
    }

    private function isStatusQuery($query)
    {
        return strpos($query, 'status') !== false;
    }

    private function handleStatusQuery($query)
    {
        if (strpos($query, 'invoice') !== false || strpos($query, 'invois') !== false) {
            return [
                'sql' => 'SELECT status, COUNT(*) as jumlah FROM invoice GROUP BY status',
                'description' => 'Status invois mengikut kategori'
            ];
        }

        return null;
    }

    private function isSummaryQuery($query)
    {
        $summaryKeywords = ['ringkasan', 'summary', 'statistik', 'statistic', 'overview'];
        foreach ($summaryKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function handleSummaryQuery($query)
    {
        if (strpos($query, 'bisnes') !== false || strpos($query, 'perniagaan') !== false) {
            return [
                'sql' => 'SELECT nama_bisnes, nama_syarikat, no_tel FROM bisnes LIMIT 5',
                'description' => 'Ringkasan perniagaan dalam sistem'
            ];
        }

        return null;
    }

    public function formatQueryResult($result, $description = '')
    {
        if (empty($result)) {
            return "Tiada data ditemui.";
        }

        $output = $description ? "**$description**\n\n" : "";

        if (is_array($result) && count($result) > 0) {
            // Get column names from first row
            $columns = array_keys((array)$result[0]);

            // Create table header
            $output .= "| " . implode(" | ", $columns) . " |\n";
            $output .= "|" . str_repeat("---|", count($columns)) . "\n";

            // Add data rows
            foreach ($result as $row) {
                $rowData = [];
                foreach ($columns as $column) {
                    $value = $row->$column ?? '';
                    // Truncate long values
                    $value = strlen($value) > 50 ? substr($value, 0, 47) . "..." : $value;
                    $rowData[] = $value;
                }
                $output .= "| " . implode(" | ", $rowData) . " |\n";
            }

            $output .= "\n**Jumlah rekod: " . count($result) . "**";
        }

        return $output;
    }

    public function getTableSummary()
    {
        $summary = [];

        foreach ($this->allowedTables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    $count = DB::table($table)->count();
                    $summary[$table] = [
                        'description' => $this->tableDescriptions[$table] ?? 'Table data',
                        'record_count' => $count
                    ];
                } catch (\Exception $e) {
                    $summary[$table] = [
                        'description' => $this->tableDescriptions[$table] ?? 'Table data',
                        'record_count' => 'Error: ' . $e->getMessage()
                    ];
                }
            }
        }

        return $summary;
    }
}