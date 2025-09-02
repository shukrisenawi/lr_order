<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class DynamicDatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set up dynamic database connection based on cache preference
        $this->setupDynamicDatabaseConnection();
    }

    private function setupDynamicDatabaseConnection()
    {
        $dbPreference = Cache::get('database_preference', 'local');

        if ($dbPreference === 'live') {
            $this->switchToLiveDatabase();
        } else {
            $this->switchToLocalDatabase();
        }
    }

    public static function switchToLocalDatabase()
    {
        Config::set('database.connections.mysql.host', '127.0.0.1');
        Config::set('database.connections.mysql.database', 'lr_order');
        Config::set('database.connections.mysql.username', 'root');
        Config::set('database.connections.mysql.password', '');

        // Reconnect to apply changes
        DB::reconnect('mysql');
    }

    public static function switchToLiveDatabase()
    {
        Config::set('database.connections.mysql.host', '103.94.238.99');
        Config::set('database.connections.mysql.database', 'abimanyu6111_shuk_database');
        Config::set('database.connections.mysql.username', 'abimanyu6111_sumopod');
        Config::set('database.connections.mysql.password', 'smh9lEq3gLG.p2_W');

        // Reconnect to apply changes
        DB::reconnect('mysql');
    }
}
