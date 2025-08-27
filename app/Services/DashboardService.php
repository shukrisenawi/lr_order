<?php

namespace App\Services;

use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Customer;
use App\Models\CustomerBuy;
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
    public function getRevenueByMonth(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "revenue_by_month_{$this->userId}"
            : "revenue_by_month_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            $data = [];
            $months = collect(range(0, 11))->map(function ($i) {
                return Carbon::now()->subMonths($i)->format('Y-m');
            })->reverse();

            foreach ($months as $month) {
                if ($selectedBisnesId == 0) {
                    // No filtering by business, show all data for user
                    $revenue = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                        $query->where('user_id', $this->userId);
                    })
                        ->whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2))
                        ->sum('harga');
                } else {
                    // Filter by selected business
                    $revenue = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                        $query->where('bisnes_id', $selectedBisnesId);
                    })
                        ->whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2))
                        ->sum('harga');
                }

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
    public function getProspectConversionRate(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "conversion_rate_{$this->userId}"
            : "conversion_rate_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            if ($selectedBisnesId == 0) {
                // No filtering by business, show all data for user
                $totalProspects = Customer::whereHas('bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })->count();
                $convertedProspects = Customer::whereHas('bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })->count();
            } else {
                // Filter by selected business
                $totalProspects = Customer::where('bisnes_id', $selectedBisnesId)->count();
                $convertedProspects = Customer::where('bisnes_id', $selectedBisnesId)->count();
            }

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
    public function getTopProducts(int $limit = 5, int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "top_products_{$this->userId}_{$limit}"
            : "top_products_{$this->userId}_{$limit}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($limit, $selectedBisnesId) {
            // Note: Produk table doesn't have bisnes_id, so we can't filter by business
            // We'll return the same data regardless of business selection
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
    public function getRecentActivities(int $limit = 10, int $selectedBisnesId = 0): array
    {
        $activities = collect();

        if ($selectedBisnesId == 0) {
            // Recent businesses (only show when no specific business is selected)
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
        } else {
            // When a specific business is selected, don't show business activities
            $businesses = collect();
        }

        if ($selectedBisnesId == 0) {
            // Recent prospects (all businesses)
            $prospects = Customer::whereHas('bisnes', function ($query) {
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
        } else {
            // Recent prospects (specific business)
            $prospects = Customer::where('bisnes_id', $selectedBisnesId)
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
        }

        if ($selectedBisnesId == 0) {
            // Recent purchases (all businesses)
            $purchases = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', $this->userId);
            })
                ->with(['customerAlamat.customer', 'produk'])
                ->latest()
                ->limit(4)
                ->get()
                ->map(function ($purchase) {
                    $productName = $purchase->produk ? $purchase->produk->nama : 'Unknown Product';
                    $prospectName = $purchase->customerAlamat && $purchase->customerAlamat->customer
                        ? $purchase->customerAlamat->customer->gelaran
                        : 'Unknown Prospect';

                    return [
                        'type' => 'purchase',
                        'description' => "Purchase: {$productName} by {$prospectName}",
                        'time' => $purchase->created_at ? $purchase->created_at->diffForHumans() : 'Unknown',
                        'icon' => 'shopping-cart',
                        'color' => 'rose'
                    ];
                });
        } else {
            // Recent purchases (specific business)
            $purchases = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                $query->where('bisnes_id', $selectedBisnesId);
            })
                ->with(['customerAlamat.customer', 'produk'])
                ->latest()
                ->limit(4)
                ->get()
                ->map(function ($purchase) {
                    $productName = $purchase->produk ? $purchase->produk->nama : 'Unknown Product';
                    $prospectName = $purchase->customerAlamat && $purchase->customerAlamat->customer
                        ? $purchase->customerAlamat->customer->gelaran
                        : 'Unknown Prospect';

                    return [
                        'type' => 'purchase',
                        'description' => "Purchase: {$productName} by {$prospectName}",
                        'time' => $purchase->created_at ? $purchase->created_at->diffForHumans() : 'Unknown',
                        'icon' => 'shopping-cart',
                        'color' => 'rose'
                    ];
                });
        }

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
    public function getGrowthMetrics(int $selectedBisnesId = 0): array
    {
        $cacheKey = $selectedBisnesId == 0
            ? "growth_metrics_{$this->userId}"
            : "growth_metrics_{$this->userId}_bisnes_{$selectedBisnesId}";

        return Cache::remember($cacheKey, 3600, function () use ($selectedBisnesId) {
            $currentMonth = Carbon::now();
            $previousMonth = Carbon::now()->subMonth();

            if ($selectedBisnesId == 0) {
                // Business growth (all businesses)
                $currentBusinesses = Bisnes::where('user_id', $this->userId)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count();
                $previousBusinesses = Bisnes::where('user_id', $this->userId)
                    ->whereMonth('created_at', $previousMonth->month)
                    ->count();

                // Revenue growth (all businesses)
                $currentRevenue = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })
                    ->whereMonth('created_at', $currentMonth->month)
                    ->sum('harga');
                $previousRevenue = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })
                    ->whereMonth('created_at', $previousMonth->month)
                    ->sum('harga');

                // Prospect growth (all businesses)
                $currentProspects = Customer::whereHas('bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count();
                $previousProspects = Customer::whereHas('bisnes', function ($query) {
                    $query->where('user_id', $this->userId);
                })
                    ->whereMonth('created_at', $previousMonth->month)
                    ->count();
            } else {
                // Business growth (specific business - always 1 since we're looking at a specific business)
                $currentBusinesses = 1;
                $previousBusinesses = 1;

                // Revenue growth (specific business)
                $currentRevenue = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                    $query->where('bisnes_id', $selectedBisnesId);
                })
                    ->whereMonth('created_at', $currentMonth->month)
                    ->sum('harga');
                $previousRevenue = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                    $query->where('bisnes_id', $selectedBisnesId);
                })
                    ->whereMonth('created_at', $previousMonth->month)
                    ->sum('harga');

                // Prospect growth (specific business)
                $currentProspects = Customer::where('bisnes_id', $selectedBisnesId)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->count();
                $previousProspects = Customer::where('bisnes_id', $selectedBisnesId)
                    ->whereMonth('created_at', $previousMonth->month)
                    ->count();
            }

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
        // Note: This is a simplified cache clearing approach
        // In a production environment, you might want to clear specific keys
        // based on the selected business or use cache tags
        Cache::flush();
    }
}
