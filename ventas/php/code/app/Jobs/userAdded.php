<?php

namespace App\Jobs;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class userAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;
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
        echo PHP_EOL.PHP_EOL.'In ventas::userAdded';
        print_r($this->data);
        try {
            Usuario::create($this->data);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
            throw new Exception("Error Processing Request", 1);
        }
    }
}
