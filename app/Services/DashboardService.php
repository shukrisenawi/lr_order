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
     * Clear dashboard cache
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
