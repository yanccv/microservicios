<?php

namespace App\Providers;

use App\Interfaces\DetalleFacturaInterface;
use App\Interfaces\FacturaInterface;
use App\Interfaces\SalesInterface;
use App\Interfaces\SendMessagesInterface;
use App\Repositories\DetalleFacturaRepository;
use App\Repositories\FacturaRepository;
use App\Repositories\SalesRepository;
use App\Repositories\SendMessagesQueue;
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
            SendMessagesInterface::class,
            SendMessagesQueue::class
        );

        $this->app->bind(
            SalesInterface::class,
            SalesRepository::class
        );

        $this->app->bind(
            FacturaInterface::class,
            FacturaRepository::class
        );

        $this->app->bind(
            DetalleFacturaInterface::class,
            DetalleFacturaRepository::class
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
