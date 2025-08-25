<?php

namespace App\Services;

use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Prospek;
use App\Models\ProspekBuy;
use Carbon\Carbon;
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
     * Get revenue data for the last 12 months
     */
    public function getRevenueByMonth(): array
    {
        return Cache::remember("revenue_by_month_{$this->userId}", 3600, function () {
            $data = [];
            $months = collect(range(0, 11))->map(function ($i) {
                return Carbon::now()->subMonths($i)->format('Y-m');
            })->reverse();

            foreach ($months as $month) {
                $revenue = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })
                    ->whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->sum('harga');

                $data[] = [
                    'month' => Carbon::parse($month)->format('M Y'),
                    'revenue' => (float) $revenue
                ];
            }

            return $data;
        });
    }

    /**
     * Get prospect conversion rates
     */
    public function getProspectConversionRate(): array
    {
        return Cache::remember("conversion_rate_{$this->userId}", 3600, function () {
            $totalProspects = Prospek::whereHas('bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })->count();
            $convertedProspects = Prospek::whereHas('bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })->where('status', 'converted')->count();

            return [
                'total' => $totalProspects,
                'converted' => $convertedProspects,
                'rate' => $totalProspects > 0 ? round(($convertedProspects / $totalProspects) * 100, 2) : 0
            ];
        });
    }

    /**
     * Get top performing products
     */
    public function getTopProducts(int $limit = 5): array
    {
        return Cache::remember("top_products_{$this->userId}_{$limit}", 3600, function () use ($limit) {
            return Produk::withCount(['purchases as total_sales'])
                ->orderBy('total_sales', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->nama,
                        'sales' => $product->total_sales ?? 0,
                        'revenue' => $product->purchases ? $product->purchases->sum('harga') : 0
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities(int $limit = 10): array
    {
        $activities = collect();

        // Recent businesses
        $businesses = Bisnes::where('user_id', $this->userId)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($business) {
                return [
                    'type' => 'business',
                    'description' => "New business added: {$business->nama_bines}",
                    'time' => $business->created_at ? $business->created_at->diffForHumans() : 'Unknown',
                    'icon' => 'building',
                    'color' => 'blue'
                ];
            });

        // Recent prospects
        $prospects = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', $this->userId);
        })
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($prospect) {
                return [
                    'type' => 'prospect',
                    'description' => "New prospect: {$prospect->gelaran}",
                    'time' => $prospect->created_at ? $prospect->created_at->diffForHumans() : 'Unknown',
                    'icon' => 'user',
                    'color' => 'amber'
                ];
            });

        // Recent purchases
        $purchases = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
            $query->where('user_id', $this->userId);
        })
            ->with(['prospekAlamat.prospek', 'produk'])
            ->latest()
            ->limit(4)
            ->get()
            ->map(function ($purchase) {
                $productName = $purchase->produk ? $purchase->produk->nama : 'Unknown Product';
                $prospectName = $purchase->prospekAlamat && $purchase->prospekAlamat->prospek
                    ? $purchase->prospekAlamat->prospek->gelaran
                    : 'Unknown Prospect';

                return [
                    'type' => 'purchase',
                    'description' => "Purchase: {$productName} by {$prospectName}",
                    'time' => $purchase->created_at ? $purchase->created_at->diffForHumans() : 'Unknown',
                    'icon' => 'shopping-cart',
                    'color' => 'rose'
                ];
            });

        return $activities
            ->merge($businesses)
            ->merge($prospects)
            ->merge($purchases)
            ->sortByDesc('date')
            ->take($limit)
            ->values()
            ->toArray();
    }

    /**
     * Get growth metrics compared to previous period
     */
    public function getGrowthMetrics(): array
    {
        return Cache::remember("growth_metrics_{$this->userId}", 3600, function () {
            $currentMonth = Carbon::now();
            $previousMonth = Carbon::now()->subMonth();

            // Business growth
            $currentBusinesses = Bisnes::where('user_id', $this->userId)
                ->whereMonth('created_at', $currentMonth->month)
                ->count();
            $previousBusinesses = Bisnes::where('user_id', $this->userId)
                ->whereMonth('created_at', $previousMonth->month)
                ->count();

            // Revenue growth
            $currentRevenue = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })
                ->whereMonth('created_at', $currentMonth->month)
                ->sum('harga');
            $previousRevenue = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })
                ->whereMonth('created_at', $previousMonth->month)
                ->sum('harga');

            // Prospect growth
            $currentProspects = Prospek::whereHas('bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })
                ->whereMonth('created_at', $currentMonth->month)
                ->count();
            $previousProspects = Prospek::whereHas('bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })
                ->whereMonth('created_at', $previousMonth->month)
                ->count();

            return [
                'businesses' => [
                    'current' => $currentBusinesses,
                    'previous' => $previousBusinesses,
                    'growth' => $previousBusinesses > 0 ? round((($currentBusinesses - $previousBusinesses) / $previousBusinesses) * 100, 2) : 0
                ],
                'revenue' => [
                    'current' => (float) $currentRevenue,
                    'previous' => (float) $previousRevenue,
                    'growth' => $previousRevenue > 0 ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 2) : 0
                ],
                'prospects' => [
                    'current' => $currentProspects,
                    'previous' => $previousProspects,
                    'growth' => $previousProspects > 0 ? round((($currentProspects - $previousProspects) / $previousProspects) * 100, 2) : 0
                ]
            ];
        });
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache(): void
    {
        $keys = [
            "revenue_by_month_{$this->userId}",
            "conversion_rate_{$this->userId}",
            "top_products_{$this->userId}_5",
            "growth_metrics_{$this->userId}"
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
