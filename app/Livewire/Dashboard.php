<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Customer;
use App\Models\CustomerBuy;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalBisnes = 0;
    public $totalProduk = 0;
    public $totalCustomer = 0;
    public $totalPembelian = 0;
    public $totalRevenue = 0;
    public $value2 = 0; // New property for value2

    // Chart data
    public $revenueByMonth = [];
    public $conversionRate = [];
    public $topProducts = [];
    public $recentActivities = [];
    public $growthMetrics = [];

    protected $selectedBisnesId = 0;

    public function mount(DashboardService $dashboardService)
    {
        $this->selectedBisnesId = session('selected_bisnes_id', 0);
        $this->loadStats();
        $this->loadAnalytics($dashboardService);
    }

    public function loadStats()
    {
        // Get the selected business ID from session
        $selectedBisnesId = session('selected_bisnes_id', 0);

        // Load value2 (this could be any business-related metric)
        $this->value2 = $this->calculateValue2($selectedBisnesId);

        if ($selectedBisnesId == 0) {
            // No filtering by business, show all data for user
            $this->totalBisnes = Bisnes::where('user_id', Auth::id())->count();
            $this->totalProduk = Produk::count(); // Produk table doesn't have user_id
            $this->totalCustomer = Customer::whereHas('bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })->count();
            $this->totalPembelian = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })->count();
            $this->totalRevenue = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })->sum('harga');
        } else {
            // Filter by selected business
            $this->totalBisnes = 1; // Since we're filtering by a specific business
            $this->totalProduk = Produk::count(); // Produk table doesn't have user_id or bisnes_id
            $this->totalCustomer = Customer::where('bisnes_id', $selectedBisnesId)->count();
            $this->totalPembelian = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                $query->where('bisnes_id', $selectedBisnesId);
            })->count();
            $this->totalRevenue = CustomerBuy::whereHas('customerAlamat.customer', function ($query) use ($selectedBisnesId) {
                $query->where('bisnes_id', $selectedBisnesId);
            })->sum('harga');
        }
    }

    private function calculateValue2($selectedBisnesId)
    {
        // This is a placeholder for value2 calculation
        // You can replace this with any business metric you want to display
        if ($selectedBisnesId == 0) {
            // For all businesses, count total active businesses
            return Bisnes::where('user_id', Auth::id())->where('on', 1)->count();
        } else {
            // For specific business, check if it's active
            $bisnes = Bisnes::find($selectedBisnesId);
            return $bisnes && $bisnes->on ? 1 : 0;
        }
    }

    public function loadAnalytics(DashboardService $dashboardService)
    {
        // $selectedBisnesId = session('selected_bisnes_id', 0);
        // $this->revenueByMonth = $dashboardService->getRevenueByMonth($selectedBisnesId);
        // $this->conversionRate = $dashboardService->getProspectConversionRate($selectedBisnesId);
        // $this->topProducts = $dashboardService->getTopProducts(5, $selectedBisnesId);
        // $this->recentActivities = $dashboardService->getRecentActivities(10, $selectedBisnesId);
        // $this->growthMetrics = $dashboardService->getGrowthMetrics($selectedBisnesId);
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
