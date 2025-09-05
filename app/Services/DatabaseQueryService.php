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
        $countKeywords = ['berapa banyak', 'jumlah', 'berapa orang', 'berapa buah', 'total', 'count', 'ada berapa'];
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

        if (strpos($query, 'penduduk') !== false || strpos($query, 'data penduduk') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM data_penduduk',
                'description' => 'Jumlah data penduduk dalam sistem'
            ];
        }

        if (strpos($query, 'invoice item') !== false || strpos($query, 'item invois') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM invoice_item',
                'description' => 'Jumlah item invois dalam sistem'
            ];
        }

        if (strpos($query, 'gambar') !== false || strpos($query, 'image') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM gambar',
                'description' => 'Jumlah gambar dalam sistem'
            ];
        }

        if (strpos($query, 'iklan') !== false || strpos($query, 'advertisement') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM iklan',
                'description' => 'Jumlah iklan dalam sistem'
            ];
        }

        if (strpos($query, 'tracking') !== false || strpos($query, 'penjejakan') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM tracking',
                'description' => 'Jumlah data tracking dalam sistem'
            ];
        }

        if (strpos($query, 'jadual pengajian') !== false || strpos($query, 'jadual') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM jadual_pengajian',
                'description' => 'Jumlah jadual pengajian dalam sistem'
            ];
        }

        if (strpos($query, 'waktu solat') !== false || strpos($query, 'solat') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM waktu_solat',
                'description' => 'Jumlah jadual waktu solat dalam sistem'
            ];
        }

        if (strpos($query, 'anak khariah') !== false || strpos($query, 'pelajar') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM anak_khariah',
                'description' => 'Jumlah anak khariah dalam sistem'
            ];
        }

        if (strpos($query, 'tenaga pengajar') !== false || strpos($query, 'guru') !== false || strpos($query, 'pengajar') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM tenaga_pengajar',
                'description' => 'Jumlah tenaga pengajar dalam sistem'
            ];
        }

        if (strpos($query, 'kitab pengajian') !== false || strpos($query, 'kitab') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM kitab_pengajian',
                'description' => 'Jumlah kitab pengajian dalam sistem'
            ];
        }

        if (strpos($query, 'pengajian') !== false && strpos($query, 'kitab') === false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM pengajian',
                'description' => 'Jumlah sesi pengajian dalam sistem'
            ];
        }

        if (strpos($query, 'program') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM program',
                'description' => 'Jumlah program dalam sistem'
            ];
        }

        if (strpos($query, 'pengumuman') !== false || strpos($query, 'announcement') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM pengumuman',
                'description' => 'Jumlah pengumuman dalam sistem'
            ];
        }

        if (strpos($query, 'landing page') !== false || strpos($query, 'laman web') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM landing_page',
                'description' => 'Jumlah landing page dalam sistem'
            ];
        }

        if (strpos($query, 'kumpulan') !== false || strpos($query, 'group') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM kumpulan',
                'description' => 'Jumlah kumpulan dalam sistem'
            ];
        }

        if (strpos($query, 'kod cula') !== false || strpos($query, 'kod') !== false) {
            return [
                'sql' => 'SELECT COUNT(*) as total FROM kod_cula',
                'description' => 'Jumlah kod cula dalam sistem'
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

        if (strpos($query, 'penduduk') !== false || strpos($query, 'data penduduk') !== false) {
            return [
                'sql' => 'SELECT nama_pemilih, no_kp_baru, jantina, bangsa, nama_lokaliti FROM data_penduduk ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 data penduduk terkini'
            ];
        }

        if (strpos($query, 'invoice item') !== false || strpos($query, 'item invois') !== false) {
            return [
                'sql' => 'SELECT invoice_id, nama_produk, kuantiti, harga_seunit FROM invoice_item ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 item invois terkini'
            ];
        }

        if (strpos($query, 'gambar') !== false || strpos($query, 'image') !== false) {
            return [
                'sql' => 'SELECT nama_fail, saiz_fail, jenis_fail FROM gambar ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 gambar terkini'
            ];
        }

        if (strpos($query, 'iklan') !== false || strpos($query, 'advertisement') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan, status FROM iklan ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 iklan terkini'
            ];
        }

        if (strpos($query, 'tracking') !== false || strpos($query, 'penjejakan') !== false) {
            return [
                'sql' => 'SELECT invoice_id, status, tarikh FROM tracking ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 data tracking terkini'
            ];
        }

        if (strpos($query, 'jadual pengajian') !== false || strpos($query, 'jadual') !== false) {
            return [
                'sql' => 'SELECT tajuk, tarikh, masa, tempat FROM jadual_pengajian ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 jadual pengajian terkini'
            ];
        }

        if (strpos($query, 'waktu solat') !== false || strpos($query, 'solat') !== false) {
            return [
                'sql' => 'SELECT nama_solat, waktu, tarikh FROM waktu_solat ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 waktu solat terkini'
            ];
        }

        if (strpos($query, 'anak khariah') !== false || strpos($query, 'pelajar') !== false) {
            return [
                'sql' => 'SELECT nama, no_ic, alamat FROM anak_khariah ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 anak khariah terkini'
            ];
        }

        if (strpos($query, 'tenaga pengajar') !== false || strpos($query, 'guru') !== false || strpos($query, 'pengajar') !== false) {
            return [
                'sql' => 'SELECT nama, no_tel, kepakaran FROM tenaga_pengajar ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 tenaga pengajar terkini'
            ];
        }

        if (strpos($query, 'kitab pengajian') !== false || strpos($query, 'kitab') !== false) {
            return [
                'sql' => 'SELECT tajuk, pengarang, penerbit FROM kitab_pengajian ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 kitab pengajian terkini'
            ];
        }

        if (strpos($query, 'pengajian') !== false && strpos($query, 'kitab') === false) {
            return [
                'sql' => 'SELECT tajuk, tarikh, tempat FROM pengajian ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 sesi pengajian terkini'
            ];
        }

        if (strpos($query, 'program') !== false) {
            return [
                'sql' => 'SELECT nama_program, tarikh, tempat FROM program ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 program terkini'
            ];
        }

        if (strpos($query, 'pengumuman') !== false || strpos($query, 'announcement') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan, tarikh FROM pengumuman ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 pengumuman terkini'
            ];
        }

        if (strpos($query, 'landing page') !== false || strpos($query, 'laman web') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan, status FROM landing_page ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 landing page terkini'
            ];
        }

        if (strpos($query, 'kumpulan') !== false || strpos($query, 'group') !== false) {
            return [
                'sql' => 'SELECT nama_kumpulan, deskripsi FROM kumpulan ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 kumpulan terkini'
            ];
        }

        if (strpos($query, 'kod cula') !== false || strpos($query, 'kod') !== false) {
            return [
                'sql' => 'SELECT kod, nama_lokaliti FROM kod_cula ORDER BY created_at DESC LIMIT 10',
                'description' => 'Senarai 10 kod cula terkini'
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

        if (strpos($query, 'penduduk') !== false || strpos($query, 'data penduduk') !== false) {
            return [
                'sql' => 'SELECT nama_pemilih, no_kp_baru, jantina, bangsa FROM data_penduduk WHERE nama_pemilih LIKE ? OR no_kp_baru LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian data penduduk untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'invoice item') !== false || strpos($query, 'item invois') !== false) {
            return [
                'sql' => 'SELECT invoice_id, nama_produk, kuantiti FROM invoice_item WHERE nama_produk LIKE ?',
                'bindings' => ["%$searchTerm%"],
                'description' => "Hasil carian item invois untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'gambar') !== false || strpos($query, 'image') !== false) {
            return [
                'sql' => 'SELECT nama_fail, saiz_fail FROM gambar WHERE nama_fail LIKE ?',
                'bindings' => ["%$searchTerm%"],
                'description' => "Hasil carian gambar untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'iklan') !== false || strpos($query, 'advertisement') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan FROM iklan WHERE tajuk LIKE ? OR kandungan LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian iklan untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'tracking') !== false || strpos($query, 'penjejakan') !== false) {
            return [
                'sql' => 'SELECT invoice_id, status FROM tracking WHERE invoice_id LIKE ?',
                'bindings' => ["%$searchTerm%"],
                'description' => "Hasil carian tracking untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'jadual pengajian') !== false || strpos($query, 'jadual') !== false) {
            return [
                'sql' => 'SELECT tajuk, tempat FROM jadual_pengajian WHERE tajuk LIKE ? OR tempat LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian jadual pengajian untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'waktu solat') !== false || strpos($query, 'solat') !== false) {
            return [
                'sql' => 'SELECT nama_solat, waktu FROM waktu_solat WHERE nama_solat LIKE ?',
                'bindings' => ["%$searchTerm%"],
                'description' => "Hasil carian waktu solat untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'anak khariah') !== false || strpos($query, 'pelajar') !== false) {
            return [
                'sql' => 'SELECT nama, no_ic FROM anak_khariah WHERE nama LIKE ? OR no_ic LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian anak khariah untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'tenaga pengajar') !== false || strpos($query, 'guru') !== false || strpos($query, 'pengajar') !== false) {
            return [
                'sql' => 'SELECT nama, kepakaran FROM tenaga_pengajar WHERE nama LIKE ? OR kepakaran LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian tenaga pengajar untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'kitab pengajian') !== false || strpos($query, 'kitab') !== false) {
            return [
                'sql' => 'SELECT tajuk, pengarang FROM kitab_pengajian WHERE tajuk LIKE ? OR pengarang LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian kitab pengajian untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'pengajian') !== false && strpos($query, 'kitab') === false) {
            return [
                'sql' => 'SELECT tajuk, tempat FROM pengajian WHERE tajuk LIKE ? OR tempat LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian sesi pengajian untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'program') !== false) {
            return [
                'sql' => 'SELECT nama_program, tempat FROM program WHERE nama_program LIKE ? OR tempat LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian program untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'pengumuman') !== false || strpos($query, 'announcement') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan FROM pengumuman WHERE tajuk LIKE ? OR kandungan LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian pengumuman untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'landing page') !== false || strpos($query, 'laman web') !== false) {
            return [
                'sql' => 'SELECT tajuk, kandungan FROM landing_page WHERE tajuk LIKE ? OR kandungan LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian landing page untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'kumpulan') !== false || strpos($query, 'group') !== false) {
            return [
                'sql' => 'SELECT nama_kumpulan, deskripsi FROM kumpulan WHERE nama_kumpulan LIKE ? OR deskripsi LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian kumpulan untuk: '$searchTerm'"
            ];
        }

        if (strpos($query, 'kod cula') !== false || strpos($query, 'kod') !== false) {
            return [
                'sql' => 'SELECT kod, nama_lokaliti FROM kod_cula WHERE kod LIKE ? OR nama_lokaliti LIKE ?',
                'bindings' => ["%$searchTerm%", "%$searchTerm%"],
                'description' => "Hasil carian kod cula untuk: '$searchTerm'"
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