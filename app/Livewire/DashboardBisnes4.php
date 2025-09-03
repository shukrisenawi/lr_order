<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Log;

class DashboardBisnes4 extends Component
{
    // Population data
    public $populationByCula = [];
    public $populationByBangsa = [];
    public $populationByGender = [];

    protected $selectedBisnesId = 0;

    public function mount(DashboardService $dashboardService)
    {
        $this->selectedBisnesId = session('selected_bisnes_id', 0);
        $this->loadPopulationData($dashboardService);
    }

    public function loadPopulationData(DashboardService $dashboardService)
    {
        $selectedBisnesId = session('selected_bisnes_id', 0);
        $this->populationByCula = $dashboardService->getPopulationByCula($selectedBisnesId);
        $this->populationByBangsa = $dashboardService->getPopulationByBangsa($selectedBisnesId);
        $this->populationByGender = $dashboardService->getPopulationByGender($selectedBisnesId);

        // Debug: Log data untuk memastikan data diambil
        Log::info('DashboardBisnes4 Data Loaded:', [
            'cula_count' => count($this->populationByCula['cula_distribution'] ?? []),
            'bangsa_count' => count($this->populationByBangsa['bangsa_distribution'] ?? []),
            'gender_count' => count($this->populationByGender['gender_distribution'] ?? []),
            'total_population' => $this->populationByCula['total_population'] ?? 0
        ]);
    }

    public function refreshData(DashboardService $dashboardService)
    {
        $this->loadPopulationData($dashboardService);
        $dashboardService->clearCache();
        $this->dispatch('data-refreshed');
    }

    protected $listeners = ['refreshData'];

    public function render()
    {
        return view('livewire.dashboard-bisnes4');
    }
}
