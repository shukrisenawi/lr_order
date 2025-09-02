<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class DatabaseToggle extends Component
{
    public $isLiveDatabase = false;

    public function mount()
    {
        $this->checkCurrentDatabase();
    }

    public function checkCurrentDatabase()
    {
        // Check if we have a cached database preference
        $dbPreference = Cache::get('database_preference', 'local');
        $this->isLiveDatabase = ($dbPreference === 'live');
    }

    public function toggleDatabase()
    {
        try {
            if ($this->isLiveDatabase) {
                // Switch to local database
                \App\Providers\DynamicDatabaseServiceProvider::switchToLocalDatabase();
                Cache::put('database_preference', 'local', now()->addHours(24));
                $this->isLiveDatabase = false;
            } else {
                // Switch to live database
                \App\Providers\DynamicDatabaseServiceProvider::switchToLiveDatabase();
                Cache::put('database_preference', 'live', now()->addHours(24));
                $this->isLiveDatabase = true;
            }

            // Dispatch success message
            $this->dispatch('database-switched', [
                'type' => $this->isLiveDatabase ? 'live' : 'local',
                'message' => 'Database connection switched to ' . ($this->isLiveDatabase ? 'Live' : 'Local')
            ]);

        } catch (\Exception $e) {
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
