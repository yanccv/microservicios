<?php

namespace App\Console\Commands;

use App\Jobs\addProductos;
use Illuminate\Console\Command;

class productos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de Productos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        addProductos::dispatch();
        return Command::SUCCESS;
    }
}
