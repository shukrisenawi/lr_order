<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseToggle extends Component
{
    public $isLiveDatabase = false;
    public $jsonFilePath = 'database_preferences.json';

    public function mount()
    {
        $this->checkCurrentDatabase();
    }

    public function checkCurrentDatabase()
    {
        // Read from JSON file first, then cache/session as backup
        $dbPreference = $this->readDatabasePreferenceFromJson();
        if ($dbPreference === null) {
            $dbPreference = Cache::get('database_preference', null);
            if ($dbPreference === null) {
                $dbPreference = session('database_preference', 'local');
            }
        }
        $this->isLiveDatabase = ($dbPreference === 'live');
    }

    public function toggleDatabase()
    {
        try {
            Log::info('Database toggle clicked. Current state: ' . ($this->isLiveDatabase ? 'live' : 'local'));

            $newPreference = $this->isLiveDatabase ? 'local' : 'live';

            // Save preference to JSON file
            $this->saveDatabasePreferenceToJson($newPreference);

            // Update cache and session for backward compatibility
            Cache::put('database_preference', $newPreference, now()->addHours(24));
            session(['database_preference' => $newPreference]);

            // Update component state
            $this->isLiveDatabase = ($newPreference === 'live');

            // Dispatch success message
            $this->dispatch('database-switched', [
                'type' => $newPreference,
                'message' => 'Database preference saved to ' . ($newPreference === 'live' ? 'Live' : 'Local') . ' (JSON file updated)'
            ]);

            Log::info('Database preference saved to JSON file. New state: ' . $newPreference);
        } catch (\Exception $e) {
            Log::error('Database toggle failed: ' . $e->getMessage());
            $this->dispatch('database-error', [
                'message' => 'Failed to save database preference: ' . $e->getMessage()
            ]);
        }
    }

    public function applyDatabaseConnection()
    {
        try {
            $dbPreference = $this->readDatabasePreferenceFromJson();

            if ($dbPreference === 'live') {
                \App\Providers\DynamicDatabaseServiceProvider::switchToLiveDatabase();
                Log::info('Applied live database connection from JSON file');
            } else {
                \App\Providers\DynamicDatabaseServiceProvider::switchToLocalDatabase();
                Log::info('Applied local database connection from JSON file');
            }

            $this->dispatch('database-applied', [
                'type' => $dbPreference,
                'message' => 'Database connection applied from JSON file: ' . ($dbPreference === 'live' ? 'Live' : 'Local')
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to apply database connection: ' . $e->getMessage());
            $this->dispatch('database-error', [
                'message' => 'Failed to apply database connection: ' . $e->getMessage()
            ]);
        }
    }

    private function saveDatabasePreferenceToJson($preference)
    {
        $data = [
            'database_preference' => $preference,
            'timestamp' => now()->toISOString(),
            'user_id' => auth()->id(),
        ];

        Storage::disk('local')->put($this->jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function readDatabasePreferenceFromJson()
    {
        try {
            if (Storage::disk('local')->exists($this->jsonFilePath)) {
                $content = Storage::disk('local')->get($this->jsonFilePath);
                $data = json_decode($content, true);
                return $data['database_preference'] ?? null;
            }
        } catch (\Exception $e) {
            Log::error('Failed to read database preference from JSON: ' . $e->getMessage());
        }

        return null;
    }

    public function render()
    {
        return view('livewire.database-toggle');
    }
}
