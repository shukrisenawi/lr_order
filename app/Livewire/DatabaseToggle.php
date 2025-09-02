<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DatabaseToggle extends Component
{
    public $isLiveDatabase = false;

    public function mount()
    {
        $this->checkCurrentDatabase();
    }

    public function checkCurrentDatabase()
    {
        // Check cache first, then session as backup
        $dbPreference = Cache::get('database_preference', null);
        if ($dbPreference === null) {
            $dbPreference = session('database_preference', 'local');
        }
        $this->isLiveDatabase = ($dbPreference === 'live');
    }

    public function toggleDatabase()
    {
        try {
            Log::info('Database toggle clicked. Current state: ' . ($this->isLiveDatabase ? 'live' : 'local'));

            if ($this->isLiveDatabase) {
                // Switch to local database
                \App\Providers\DynamicDatabaseServiceProvider::switchToLocalDatabase();
                Cache::put('database_preference', 'local', now()->addHours(24));
                session(['database_preference' => 'local']);
                $this->isLiveDatabase = false;
                Log::info('Switched to local database');
            } else {
                // Switch to live database
                \App\Providers\DynamicDatabaseServiceProvider::switchToLiveDatabase();
                Cache::put('database_preference', 'live', now()->addHours(24));
                session(['database_preference' => 'live']);
                $this->isLiveDatabase = true;
                Log::info('Switched to live database');
            }

            // Force component refresh
            $this->checkCurrentDatabase();

            // Dispatch success message
            $this->dispatch('database-switched', [
                'type' => $this->isLiveDatabase ? 'live' : 'local',
                'message' => 'Database connection switched to ' . ($this->isLiveDatabase ? 'Live' : 'Local')
            ]);

            Log::info('Database toggle completed. New state: ' . ($this->isLiveDatabase ? 'live' : 'local'));
        } catch (\Exception $e) {
            Log::error('Database toggle failed: ' . $e->getMessage());
            $this->dispatch('database-error', [
                'message' => 'Failed to switch database: ' . $e->getMessage()
            ]);
        }
    }


    public function render()
    {
        return view('livewire.database-toggle');
    }
}
