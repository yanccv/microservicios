<?php

namespace App\Jobs;

use App\Models\Facturas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class saleAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $facturaInfo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->facturaInfo = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo PHP_EOL.PHP_EOL.'In usuarios::saleAdded';
        print_r($this->facturaInfo);
        $fechaYHora = $this->facturaInfo['created_at'];
        $this->facturaInfo['created_at'] = Carbon::parse($fechaYHora);
        Facturas::create($this->facturaInfo);
    }
}
