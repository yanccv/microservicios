<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Producto;
use Illuminate\Container\Attributes\Database;
use Illuminate\Http\Request;

class facturaController extends Controller
{

    var $conditionalFactura = [
        'idusuario' => 'required'
    ];

    var $conditionalDetalleFactura = [
        'idproducto'    => 'required',
        'producto'      => 'required',
        'precio'        => 'required|integer',
        'cantidad'      => 'required|integer',
        'impuesto'      => 'required|integer',
    ];

    /**
     * Obtener informacion de Factura
     *
     * @param integer $id identificador del registro
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $factura = Factura::with('detalleFactura')->findOrFail($id);
            return $this->responseJson(200, '', $factura);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Factura no encontrada');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al no se obtuvieron datos', '', $th->getMessage());
        }
    }


    /**
     * Agregar Registro de Factura y Detalle Factura - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) //: \Illuminate\Http\JsonResponse
    {
        if (($validator = $this->validatorData($request->all(), $this->conditionalFactura)) !== true) {
            return $validator;
        }
        // echo $request->detalle. gettype($request->detalle);
        // echo '<pre>';
        // print_r(json_encode($request->detalle));
        // echo gettype(json_decode($request->detalle));
        // echo '</pre>';
        foreach ($request->detalleProducto as $fieldProduct => $productoDetalle) {
            // Buscar el Producto en mi miro
            try {
                $producto = Producto::findOrFail($productoDetalle['idproducto']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
                return $this->responseJson(404, 'Producto no encontrado');
            } catch (\Throwable $th) {
                return $this->responseJson(500, 'Error al no se obtuvieron datos', '', $th->getMessage());
            }


            $detalleFactura = new DetalleFactura();

            if (($validator = $this->validatorData($productoDetalle, $this->conditionalDetalleFactura)) !== true) {
                return $validator;
            }

            return $detalleFactura->fill($productoDetalle, $producto);
        }


        try {
            DB::transaction(function () use ($request) {
                $factura = new Factura();
                $factura->idusuario = $request->idusuario;
                // Crear los detalles de la factura
                foreach ($request->detalles as $detalle) {
                    $factura->detalles()->create($detalle);
                }
                return $this->responseJson(500, 'Venta Procesada', $factura);
            });
        } catch (\illuminate\Database\QueryException $e){
            return $this->responseJson(500, 'Error al guardar los datos', '', $e->getMessage());
        }
         catch (\Throwable $th) {
            return $this->responseJson(500, 'Error ineperado', '', $th->getMessage());
        }
        return $this->addData(Producto::class, $request);
    }
}
