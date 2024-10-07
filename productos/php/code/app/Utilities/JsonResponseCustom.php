<?php
namespace App\Utilities;

use Illuminate\Http\JsonResponse;

class JsonResponseCustom
{
    public static $CODE_SUCCESS = 200;
    public static $CODE_CREATED_SUCCESS = 201;
    public static $CODE_BAD_REQUEST = 400;
    public static $CODE_NOT_FOUND = 404;
    public static $CODE_EXCEPTION = 500;
    public static $CODE_FAILED_VALIDATION = 422;

     /**
      * Devuelve la respuesta en formato Json
      *
      * @param [type] $dataToReturn array con los indices [status?,mensaje?, data?, httcode?, error?]
      * @return JsonResponse
      */
    public static function sendJson($dataToReturn) : JsonResponse
    {
        // print_r($dataToReturn);
        try {
            if (!isset($dataToReturn['httpCode'])) {
                throw new Exception("HttpCode no puede estar vacio", 1);
            }
            return response()->json(
                $dataToReturn,
                $dataToReturn['httpCode']
            );
        } catch (\Throwable $th) {
            return JsonResponseCustom::sendJson(['status' => false, 'error' => $th->getMessage(), 'httpCode' => 500]);
        }

    }

    // public static function success(string $mensaje = '', array $data = [], int $code) : JsonResponse
    // {
    //     $dataResponse = array_filter(['status' => true, 'mensaje' => $mensaje, 'data' => $data]);
    //     // $dataResponse = array_merge($response, $dataResponseDefault);
    //     return response()->json($dataResponse, JsonResponseCustom::$CODE_SUCCESS);
    // }

    // public static function notFound($id)
    // {
    //     return response()->json(
    //         [
    //             'status'    => false,
    //             'mensaje'   => 'Registro no encontrado',
    //             'data' => $id
    //         ],
    //         JsonResponseCustom::$CODE_NOT_FOUND
    //     );
    // }

    // public static function deleteRecord()
    // {
    //     return response()->json(
    //         [
    //             'status'    => true,
    //             'mensaje'   => 'Registro eliminado',
    //         ],
    //         JsonResponseCustom::$CODE_SUCCESS
    //     );
    // }

    // public static function fail(array $response, int $code)
    // {
    //     $dataResponseDefault = ['status' => false, 'httpCode' => $code];
    //     $dataResponse = array_merge($response, $dataResponseDefault);
    //     return response()->json($dataResponse, $code);
    // }
}
