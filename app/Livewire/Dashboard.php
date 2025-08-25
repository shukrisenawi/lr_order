<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Prospek;
use App\Models\ProspekBuy;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalBisnes = 0;
    public $totalProduk = 0;
    public $totalProspek = 0;
    public $totalPembelian = 0;
    public $totalRevenue = 0;

    // Chart data
    public $revenueByMonth = [];
    public $conversionRate = [];
    public $topProducts = [];
    public $recentActivities = [];
    public $growthMetrics = [];

    public function mount(DashboardService $dashboardService)
    {
        $this->loadStats();
        $this->loadAnalytics($dashboardService);
    }

    public function loadStats()
    {
        $this->totalBisnes = Bisnes::where('user_id', Auth::id())->count();
        $this->totalProduk = Produk::count(); // Produk table doesn't have user_id
        $this->totalProspek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $this->totalPembelian = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $this->totalRevenue = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->sum('harga');
    }

    public function loadAnalytics(DashboardService $dashboardService)
    {
        $this->revenueByMonth = $dashboardService->getRevenueByMonth();
        $this->conversionRate = $dashboardService->getProspectConversionRate();
        $this->topProducts = $dashboardService->getTopProducts();
        $this->recentActivities = $dashboardService->getRecentActivities();
        $this->growthMetrics = $dashboardService->getGrowthMetrics();
    }

    public function refreshStats(DashboardService $dashboardService)
    {
        $this->loadStats();
        $this->loadAnalytics($dashboardService);
        $dashboardService->clearCache();
        $this->dispatch('stats-updated');
    }

    protected $listeners = ['refreshStats'];

    public function render()
    {
        return view('livewire.dashboard');
    }
}
