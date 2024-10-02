<?php

namespace App\Providers;

use App\Interfaces\UnidadesRepositoryInterface;
use App\Repositories\UnidadesRepository;
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
        $this->app->bind(
            UnidadesRepositoryInterface::class,
            UnidadesRepository::class

        );
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
