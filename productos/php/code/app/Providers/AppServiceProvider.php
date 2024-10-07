<?php

namespace App\Providers;

use App\Interfaces\CategoriasBaseInterface;
use App\Interfaces\UnidadesRepositoryInterface;
use App\Repositories\UnidadesRepository;
use App\Repositories\CategoriasRepository;
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

        $this->app->bind(
            CategoriasBaseInterface::class,
            CategoriasRepository::class
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
