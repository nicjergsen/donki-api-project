<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\InstrumentRepository;
use App\Infrastructure\Repositories\DonkiInstrumentRepository;
use App\Domain\Repositories\ActivityRepository;
use App\Infrastructure\Repositories\DonkiActivityRepository;
use App\Application\Services\InstrumentDuplicationRemovalService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InstrumentRepository::class, DonkiInstrumentRepository::class);
        $this->app->bind(ActivityRepository::class, DonkiActivityRepository::class);
        $this->app->singleton(InstrumentDuplicationRemovalService::class, function ($app) {
            return new InstrumentDuplicationRemovalService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
