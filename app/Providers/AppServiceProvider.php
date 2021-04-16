<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\CustomerObserver;
use App\Customer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Customer::observe(CustomerObserver::class);
        Relation::morphMap([
            'customer' => 'App\Customer',
            'distributor' => 'App\Distributor',
            'branch' => 'App\Branch'
        ]);
        Passport::tokensExpireIn(Carbon::now()->addDays(5));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
