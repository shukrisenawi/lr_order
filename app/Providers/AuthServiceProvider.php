<?php

namespace App\Providers;

use App\Models\Bisnes;
use App\Models\Prospek;
use App\Policies\BisnesPolicy;
use App\Policies\ProspekPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Bisnes::class => BisnesPolicy::class,
        Prospek::class => ProspekPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
