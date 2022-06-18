<?php

namespace App\Providers;

use App\Console\Commands\BinancePricing;
use App\Services\BotService;
use App\Services\BotServiceInterface;
use App\Services\ExchangeServiceInterface;
use App\Services\FakeBinanceService;
use Illuminate\Support\ServiceProvider;

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
        // TODO Is this needed?
        if ($this->app->runningInConsole()) {
            $this->commands([
                BinancePricing::class,
            ]);
        }

        $this->app->bind(ExchangeServiceInterface::class, FakeBinanceService::class);
        $this->app->bind(BotServiceInterface::class, BotService::class);
    }
}
