<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Producto;
// use Illuminate\Container\Attributes\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class facturaController extends Controller
{

    var $conditionalFactura = [
        'usuarios_id' => 'required'
    ];

    var $conditionalDetalleFactura = [
        'productos_id'    => 'required',
        'producto'      => 'required',
        'precio'        => 'required|numeric',
        'cantidad'      => 'required|numeric',
    ];

    private $saleRepository;

    public function __construct(UnidadesRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * Obtener informacion de Factura
     *
     * @param integer $id identificador del registro
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFactura(int $id) //: \Illuminate\Http\JsonResponse
    {
        // try {
        //     $factura = Factura::with('detalleFactura')->findOrFail($id);
        //     return $this->responseJson(200, '', $factura);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
        //     return $this->responseJson(404, 'Factura no encontrada');
        // } catch (\Throwable $th) {
        //     return $this->responseJson(500, 'Error al no se obtuvieron datos', '', $th->getMessage());
        // }
    }


    /**
     * Agregar Registro de Factura y Detalle Factura - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) //: \Illuminate\Http\JsonResponse
    {
        // if (($validator = $this->validatorData($request->all(), $this->conditionalFactura)) !== true) {
        //     return $validator;
        // }
        // try {
        //     DB::beginTransaction();
        //     $factura = new Factura();
        //     $factura->fill($request->toArray());
        //     $factura->save();
        //     foreach ($request->detalleProducto as $fieldProduct => $productoDetalle) {

        //         // Buscar el Producto en mi miro
        //         $producto = Producto::findOrFail($productoDetalle['productos_id']);
        //         $productoDetalle['facturas_id'] = $factura->id;
        //         $productosDetalle = array_merge($producto->toArray(), $productoDetalle);

        //         $detalleFactura = new DetalleFactura();
        //         if (($validator = $this->validatorData($productosDetalle, $this->conditionalDetalleFactura)) !== true) {
        //             return $validator;
        //         }
        //         $detalleFactura->fill($productosDetalle);
        //         $detalleFactura->save();

        //         $producto->existencia -= $productoDetalle['cantidad'];
        //         $producto->save();
        //     }
        //     $sendInfoQueue['products'] = $request->detalleProducto;
        //     $sendInfoQueue['facturas_id'] = $factura->id;
        //     Queue::pushOn('facturasQueue', 'facturaAdded', $sendInfoQueue, 'product.deleted');
        //     DB::commit();
        //     return $this->responseJson(201, 'Factura Guardada');
        // } catch (\illuminate\Database\QueryException $e){
        //     DB::rollBack();
        //     return $this->responseJson(500, 'Error al guardar los datos', '', $e->getMessage());
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
        //     DB::rollBack();
        //     return $this->responseJson(404, 'Producto no encontrado');
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     // print_r($th);
        //     return $this->responseJson(500, 'Error inesperado in factura Controller', '', $th->getMessage());
        // }
    }
}
