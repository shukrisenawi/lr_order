<?php

namespace App\Providers;

use App\Models\Bisnes;
use App\Models\Customer;
use App\Models\CustomerAlamat;
use App\Models\CustomerBuy;
use App\Policies\BisnesPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\CustomerAlamatPolicy;
use App\Policies\CustomerBuyPolicy;
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
        Customer::class => CustomerPolicy::class,
        CustomerAlamat::class => CustomerAlamatPolicy::class,
        CustomerBuy::class => CustomerBuyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
