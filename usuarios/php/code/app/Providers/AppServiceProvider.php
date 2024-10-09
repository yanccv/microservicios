<?php

namespace App\Providers;

use App\Interfaces\SendMessagesInterface;
use App\Interfaces\UsuariosInterface;
use App\Repositories\SendMessagesQueue;
use App\Repositories\UsuariosRepository;
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
            UsuariosInterface::class,
            UsuariosRepository::class
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
