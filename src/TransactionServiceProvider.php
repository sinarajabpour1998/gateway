<?php

namespace Sinarajabpour1998\Gateway;

use Sinarajabpour1998\Gateway\Core\TransactionManager;
use Sinarajabpour1998\Gateway\Facades\Transaction;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Transaction::shouldProxyTo(TransactionManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__.'/config/gateway.php' =>config_path('gateway.php')
        ], 'gateway');
    }
}
