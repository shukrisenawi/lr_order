<?php

namespace App\Services;

use App\Models\DataPenduduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    protected $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    /**
     * Get population data by cula (race/ethnicity) percentage
     */
    public function getPopulationByCula(int $selectedBisnesId = 0): array
    {
        // Clear cache for debugging
        $cacheKey = $selectedBisnesId == 0
            ? "population_by_cula_{$this->userId}"
            : "population_by_cula_{$this->userId}_bisnes_{$selectedBisnesId}";

        // Force fresh data for debugging
        Cache::forget($cacheKey);

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            // Get total population count
            $totalPopulation = DataPenduduk::count();

            // Get population grouped by cula
            $culaData = DataPenduduk::selectRaw('kod_cula, COUNT(*) as count')
                ->whereNotNull('kod_cula')
                ->where('kod_cula', '!=', '')
                ->where('kod_cula', '!=', '0')
                ->groupBy('kod_cula')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function ($item) use ($totalPopulation) {
                    $percentage = $totalPopulation > 0 ? round(($item->count / $totalPopulation) * 100, 2) : 0;
                    return [
                        'cula_code' => $item->kod_cula,
                        'count' => $item->count,
                        'percentage' => $percentage
                    ];
                })
                ->toArray();

            return [
                'total_population' => $totalPopulation,
                'cula_distribution' => $culaData
            ];
        });
    }

    /**
     * Get population data by bangsa (race) percentage
     */
    public function getPopulationByBangsa(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "population_by_bangsa_{$this->userId}"
            : "population_by_bangsa_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            // Get total population count
            $totalPopulation = DataPenduduk::count();

            // Get population grouped by bangsa
            $bangsaData = DataPenduduk::selectRaw('bangsa, COUNT(*) as count')
                ->whereNotNull('bangsa')
                ->where('bangsa', '!=', '')
                ->groupBy('bangsa')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function ($item) use ($totalPopulation) {
                    $percentage = $totalPopulation > 0 ? round(($item->count / $totalPopulation) * 100, 2) : 0;
                    return [
                        'bangsa' => $item->bangsa,
                        'count' => $item->count,
                        'percentage' => $percentage
                    ];
                })
                ->toArray();

            return [
                'total_population' => $totalPopulation,
                'bangsa_distribution' => $bangsaData
            ];
        });
    }

    /**
     * Get population data by gender
     */
    public function getPopulationByGender(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "population_by_gender_{$this->userId}"
            : "population_by_gender_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            // Get total population count
            $totalPopulation = DataPenduduk::count();

            // Get population grouped by gender
            $genderData = DataPenduduk::selectRaw('jantina, COUNT(*) as count')
                ->groupBy('jantina')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function ($item) use ($totalPopulation) {
                    $gender = $item->jantina == 'L' ? 'Lelaki' : 'Perempuan';
                    $percentage = $totalPopulation > 0 ? round(($item->count / $totalPopulation) * 100, 2) : 0;
                    return [
                        'gender' => $gender,
                        'code' => $item->jantina,
                        'count' => $item->count,
                        'percentage' => $percentage
                    ];
                })
                ->toArray();

            return [
                'total_population' => $totalPopulation,
                'gender_distribution' => $genderData
            ];
        });
    }

    /**
     * Get revenue data by month
     */
    public function getRevenueByMonth(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "revenue_by_month_{$this->userId}"
            : "revenue_by_month_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            $query = \App\Models\Invoice::selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(jumlah) as total_revenue,
                COUNT(*) as invoice_count
            ')
            ->where('status', '!=', 'cancelled') // Exclude cancelled invoices
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12); // Last 12 months

            // Filter by business if specified
            if ($selectedBisnesId > 0) {
                $query->where('bisnes_id', $selectedBisnesId);
            }

            $results = $query->get();

            $monthlyData = [];
            foreach ($results as $result) {
                $monthName = date('M Y', mktime(0, 0, 0, $result->month, 1, $result->year));
                $monthlyData[] = [
                    'month' => $monthName,
                    'year' => $result->year,
                    'month_num' => $result->month,
                    'revenue' => (float) $result->total_revenue,
                    'invoice_count' => $result->invoice_count
                ];
            }

            return [
                'monthly_revenue' => array_reverse($monthlyData), // Most recent first
                'total_revenue' => $results->sum('total_revenue'),
                'total_invoices' => $results->sum('invoice_count')
            ];
        });
    }

    /**
     * Get prospect conversion rate
     */
    public function getProspectConversionRate(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "prospect_conversion_rate_{$this->userId}"
            : "prospect_conversion_rate_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            $query = \App\Models\Prospek::query();

            // Filter by business if specified
            if ($selectedBisnesId > 0) {
                $query->where('bisnes_id', $selectedBisnesId);
            }

            $totalProspects = $query->count();
            $convertedProspects = $query->where('status', 'converted')->count();

            $conversionRate = $totalProspects > 0 ? round(($convertedProspects / $totalProspects) * 100, 2) : 0;

            return [
                'total' => $totalProspects,
                'converted_prospects' => $convertedProspects,
                'rate' => $conversionRate,
                'conversion_percentage' => $conversionRate . '%'
            ];
        });
    }

    /**
     * Get top products by sales
     */
    public function getTopProducts(int $limit = 5, int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "top_products_{$limit}_{$this->userId}"
            : "top_products_{$limit}_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($limit, $selectedBisnesId) {
            $query = \App\Models\InvoiceItem::selectRaw('
                produk_id,
                produk_custom,
                SUM(kuantiti) as total_quantity,
                SUM(kuantiti * harga) as total_revenue,
                COUNT(*) as order_count
            ')
            ->join('invoice', 'invoice_item.invoice_id', '=', 'invoice.id')
            ->where('invoice.status', '!=', 'cancelled')
            ->groupBy('produk_id', 'produk_custom')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit);

            // Filter by business if specified
            if ($selectedBisnesId > 0) {
                $query->where('invoice.bisnes_id', $selectedBisnesId);
            }

            $results = $query->get();

            $topProducts = [];
            foreach ($results as $result) {
                $productName = $result->produk_custom ?: ($result->produk ? $result->produk->nama : 'Unknown Product');

                $topProducts[] = [
                    'product_id' => $result->produk_id,
                    'product_name' => $productName,
                    'total_quantity' => (int) $result->total_quantity,
                    'total_revenue' => (float) $result->total_revenue,
                    'order_count' => $result->order_count
                ];
            }

            return $topProducts;
        });
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities(int $limit = 10, int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "recent_activities_{$limit}_{$this->userId}"
            : "recent_activities_{$limit}_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 1800, function () use ($limit, $selectedBisnesId) { // Shorter cache for recent activities
            $activities = [];

            // Recent invoices
            $invoicesQuery = \App\Models\Invoice::select('id', 'invoice_no', 'nama_penerima', 'jumlah', 'created_at')
                ->where('status', '!=', 'cancelled')
                ->orderBy('created_at', 'desc')
                ->limit($limit);

            if ($selectedBisnesId > 0) {
                $invoicesQuery->where('bisnes_id', $selectedBisnesId);
            }

            $recentInvoices = $invoicesQuery->get();
            foreach ($recentInvoices as $invoice) {
                $activities[] = [
                    'type' => 'invoice',
                    'id' => $invoice->id,
                    'title' => "Invoice {$invoice->invoice_no}",
                    'description' => "Invoice to {$invoice->nama_penerima}",
                    'amount' => (float) $invoice->jumlah,
                    'date' => $invoice->created_at->format('Y-m-d H:i:s'),
                    'timestamp' => $invoice->created_at->timestamp
                ];
            }

            // Recent customers
            $customersQuery = \App\Models\Customer::select('id', 'nama_penerima', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit($limit);

            if ($selectedBisnesId > 0) {
                $customersQuery->where('bisnes_id', $selectedBisnesId);
            }

            $recentCustomers = $customersQuery->get();
            foreach ($recentCustomers as $customer) {
                $activities[] = [
                    'type' => 'customer',
                    'id' => $customer->id,
                    'title' => "New Customer",
                    'description' => "Customer {$customer->nama_penerima} registered",
                    'amount' => null,
                    'date' => $customer->created_at->format('Y-m-d H:i:s'),
                    'timestamp' => $customer->created_at->timestamp
                ];
            }

            // Sort by timestamp and limit
            usort($activities, function($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });

            return array_slice($activities, 0, $limit);
        });
    }

    /**
     * Get growth metrics
     */
    public function getGrowthMetrics(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "growth_metrics_{$this->userId}"
            : "growth_metrics_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            // Get current month revenue
            $currentMonthQuery = \App\Models\Invoice::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->where('status', '!=', 'cancelled');

            // Get previous month revenue
            $previousMonthQuery = \App\Models\Invoice::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m') - 1)
                ->where('status', '!=', 'cancelled');

            // Filter by business if specified
            if ($selectedBisnesId > 0) {
                $currentMonthQuery->where('bisnes_id', $selectedBisnesId);
                $previousMonthQuery->where('bisnes_id', $selectedBisnesId);
            }

            $currentRevenue = $currentMonthQuery->sum('jumlah');
            $previousRevenue = $previousMonthQuery->sum('jumlah');

            $revenueGrowth = $previousRevenue > 0
                ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
                : ($currentRevenue > 0 ? 100 : 0);

            // Customer growth
            $currentMonthCustomers = \App\Models\Customer::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'));

            $previousMonthCustomers = \App\Models\Customer::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m') - 1);

            if ($selectedBisnesId > 0) {
                $currentMonthCustomers->where('bisnes_id', $selectedBisnesId);
                $previousMonthCustomers->where('bisnes_id', $selectedBisnesId);
            }

            $currentCustomerCount = $currentMonthCustomers->count();
            $previousCustomerCount = $previousMonthCustomers->count();

            $customerGrowth = $previousCustomerCount > 0
                ? round((($currentCustomerCount - $previousCustomerCount) / $previousCustomerCount) * 100, 2)
                : ($currentCustomerCount > 0 ? 100 : 0);

            return [
                'revenue_growth' => [
                    'current' => (float) $currentRevenue,
                    'previous' => (float) $previousRevenue,
                    'growth_percentage' => $revenueGrowth,
                    'growth_trend' => $revenueGrowth >= 0 ? 'up' : 'down'
                ],
                'customer_growth' => [
                    'current' => $currentCustomerCount,
                    'previous' => $previousCustomerCount,
                    'growth_percentage' => $customerGrowth,
                    'growth_trend' => $customerGrowth >= 0 ? 'up' : 'down'
                ],
                'period' => date('M Y')
            ];
        });
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
