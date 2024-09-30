<?php

namespace App\Jobs;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class productUpdated implements ShouldQueue
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
            $usuario = Producto::findOrFail($this->data['id']);
            $usuario->update($this->data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            // return $this->responseJson(404, 'Registro no encontrado');
            return false;
        } catch (\Throwable $th) {
            return false;
            // throw new Exception("Producto no Actualizado", 1);
            throw new Exception("Producto no Actualizado", 1);
        }
    }
}
