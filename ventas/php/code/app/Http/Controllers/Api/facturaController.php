<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetalleFacturaRequestValidate;
use App\Http\Requests\FacturaRequestValidate;
use App\Interfaces\SalesInterface;
use Illuminate\Http\Request;

// use Illuminate\Container\Attributes\Database;

class facturaController extends Controller
{

    // var $conditionalFactura = [
    //     'usuarios_id' => 'required'
    // ];

    // var $conditionalDetalleFactura = [
    //     'productos_id'    => 'required',
    //     'producto'      => 'required',
    //     'precio'        => 'required|numeric',
    //     'cantidad'      => 'required|numeric',
    // ];

    private $saleRepository;

    public function __construct(SalesInterface $saleRepository)
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

    public function test(FacturaRequestValidate $request1, DetalleFacturaRequestValidate $request2) //: \Illuminate\Http\JsonResponse
    {
        return $request1->validated()['Factura'];
        print_r($request1);
        print_r($request2);
    }


    /**
     * Agregar Registro de Factura y Detalle Factura - POST
     *
     * @param Request $request Valores a insertar
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(FacturaRequestValidate $factura, DetalleFacturaRequestValidate $detalleFactura) //: \Illuminate\Http\JsonResponse
    {
        return $this->saleRepository->new($factura, $detalleFactura);
        $facturaValidate = new FacturaRequestValidate();
        $facturaValidate->replace(['usuarios_id' => $request->usuarios_id]);
        // $facturaValidate->validated();
        $facturaValidator = $facturaValidate->getValidator();
        // $facturaValidator->validate();
        // // return ['request1' => $request->all()];
        // return ['req1' => $request->all() , 'req2' => $request2->all()];
        print_r($request->usuarios_id);
        // return $this->saleRepository->new($request, $request2);

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




    ////////////////////////////////////////////////////////////////////////////// Revisarrrrrrrrrrrrrrrrr
//     use App\Http\Requests\StoreVentaRequest;
// use App\Http\Requests\StoreFacturaRequest;
// use App\Http\Requests\StoreDetalleFacturaRequest;

// class FacturaController extends Controller {
//     protected $facturaService;

//     public function __construct(FacturaService $facturaService) {
//         $this->facturaService = $facturaService;
//     }

//     // Método para crear una venta (factura con productos)
//     public function store(StoreVentaRequest $request) {
//         // Los datos ya han sido validados con StoreVentaRequest
//         $validatedData = $request->validated();

//         // Dividimos los datos validados en dos partes
//         $facturaData = $this->extractFacturaData($validatedData);
//         $detalleData = $this->extractDetalleFacturaData($validatedData);

//         // Aplicamos las validaciones por separado
//         $this->validateFactura($facturaData);
//         $this->validateDetalleFactura($detalleData);

//         // Pasamos los datos al servicio
//         $factura = $this->facturaService->crearVenta($facturaData, $detalleData['productos']);

//         return response()->json($factura, 201);
//     }

//     // Método para extraer los datos de la factura
//     private function extractFacturaData(array $data)
//     {
//         return [
//             'cliente_id' => $data['cliente_id'],
//             'fecha' => $data['fecha'],
//             'estatus' => $data['estatus'],
//         ];
//     }

//     // Método para extraer los datos de los productos (detalle de factura)
//     private function extractDetalleFacturaData(array $data)
//     {
//         return [
//             'productos' => $data['productos']
//         ];
//     }

//     // Método para validar la factura usando StoreFacturaRequest
//     private function validateFactura(array $facturaData)
//     {
//         $facturaRequest = new StoreFacturaRequest($facturaData);
//         $facturaRequest->validateResolved();
//     }

//     // Método para validar el detalle de la factura (productos) usando StoreDetalleFacturaRequest
//     private function validateDetalleFactura(array $detalleData)
//     {
//         $detalleRequest = new StoreDetalleFacturaRequest($detalleData);
//         $detalleRequest->validateResolved();
//     }
// }
}
