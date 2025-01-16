<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureDates();
        $this->configureUrls();
        $this->configureVite();
    }

    /**
     * Do not allow database desctructive commands in production
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(App()->isProduction());
    }

    /**
     * Prevent lazy loading, silently discarding attributes, accessing missing attributes
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict(! App()->isProduction());
    }

    /**
     * Use immutable dates
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Force to use https
     */
    private function configureUrls(): void
    {
        URL::forceScheme('https');
    }

    /**
     * Configure vite
     */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
