<?php

namespace App\Providers;

use App\Contracts\Onboarding;
use App\Services\CsvSourceService;
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
        $this->app->singleton(Onboarding::class, function ($app) {
            switch ($app->make('config')->get('chart_source.name')) {
                case 'csv' :
                    return new CsvSourceService;
                default:
                    throw new \RuntimeException('unknown chart source');
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
