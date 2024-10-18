<?php

namespace App\Jobs;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class salesAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // realiza el descuento de la existencia segun la cantidad que venga de las facturas
        $data = $this->data;
        DB::transaction(function () use ($data) {
            foreach ($data as $productItem) {
                $producto = Producto::findOrFail($productItem['productos_id']);
                $producto->existencia -= $productItem['cantidad'];
                $producto->save();
            }
        });
    }
}
