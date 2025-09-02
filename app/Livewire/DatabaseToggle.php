<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseToggle extends Component
{
    public $isLiveDatabase = false;

    public function mount()
    {
        $this->checkCurrentDatabase();
    }

    public function checkCurrentDatabase()
    {
        try {
            $currentHost = Config::get('database.connections.mysql.host');
            $this->isLiveDatabase = ($currentHost === '103.94.238.99');
        } catch (\Exception $e) {
            $this->isLiveDatabase = false;
        }
    }

    public function toggleDatabase()
    {
        try {
            if ($this->isLiveDatabase) {
                // Switch to local database
                Config::set('database.connections.mysql.host', '127.0.0.1');
                Config::set('database.connections.mysql.database', 'lr_order');
                Config::set('database.connections.mysql.username', 'root');
                Config::set('database.connections.mysql.password', '');
                $this->isLiveDatabase = false;
            } else {
                // Switch to live database
                Config::set('database.connections.mysql.host', '103.94.238.99');
                Config::set('database.connections.mysql.database', 'abimanyu6111_shuk_database');
                Config::set('database.connections.mysql.username', 'abimanyu6111_sumopod');
                Config::set('database.connections.mysql.password', 'smh9lEq3gLG.p2_W');
                $this->isLiveDatabase = true;
            }

            // Test the connection
            DB::reconnect('mysql');

            // Dispatch success message
            $this->dispatch('database-switched', [
                'type' => $this->isLiveDatabase ? 'live' : 'local',
                'message' => 'Database connection switched to ' . ($this->isLiveDatabase ? 'Live' : 'Local')
            ]);

            // Refresh the page to ensure all components use the new connection
            return redirect(request()->header('Referer'));

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
