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
        echo PHP_EOL.'Update existencia in Product with Sale Event';
        try {
            DB::beginTransaction();
            foreach ($this->data as $productItem) {
                $producto = Producto::findOrFail($productItem['productos_id']);
                $producto->existencia -= $productItem['cantidad'];
                $producto->save();
            }
            DB::commit();
            echo PHP_EOL.'Update in Products FacturaID: ['.$this->data['facturas_id'].']';
        } catch (\illuminate\Database\QueryException $e){
            DB::rollBack();
            echo PHP_EOL.'Fail Update Products With FacturaId: ['.$this->data['facturas_id'].']';
            print_r($e->getMessage());
            return false;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            DB::rollBack();
            echo PHP_EOL.'Fail Update Products With FacturaId: ['.$this->data['facturas_id'].']';
            print_r($th->getMessage());
            return false;
        } catch (\Throwable $th) {
            DB::rollBack();
            print_r($th->getMessage());
            echo PHP_EOL.'Fail Update Products With FacturaId: ['.$this->data['facturas_id'].']';
            return false;
        }
    }
}
