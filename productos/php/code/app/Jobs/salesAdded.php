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
        try {
            DB::beginTransaction();
            foreach ($this->data as $key => $productItem) {
                $producto = Producto::findOrFail($productItem['productos_id']);
                $producto->existencia -= $productItem['cantidad'];
                $producto->save();
            }
        } catch (\illuminate\Database\QueryException $e){
            DB::rollBack();
            return $this->responseJson(500, 'Error al guardar los datos', '', $e->getMessage());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            DB::rollBack();
            return $this->responseJson(404, 'Producto no encontrado');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseJson(500, 'Error inesperado', '', $th->getMessage());
        }
    }
}
