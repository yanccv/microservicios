<?php

namespace App\Http\Controllers;

abstract class Controller
{
        /**
     * respuesta generalizada de la Api solo en formato Json
     *
     * @param integer $httpCode
     * @param string $message Mensaje que se entregar
     * @param [array] $data informacion a entregar
     * @param string|null $error si ocurre se entregara
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson(int $httpCode, string $message, $data = null, string $error = null) : \Illuminate\Http\JsonResponse
    {
        $response = array_filter([
            'message' => $message,
            'data' => $data,
            'error' => $error,
            'status' => $httpCode
        ]);

        return response()->json($response, $httpCode);
    }

    /**
     * Valida la data que ingresa desde el Front
     *
     * @param Request $request Data a Validar
     * @param array $conditions validaciones a realizar campo a campo
     * @return \Illuminate\Http\JsonResponse | true
     */
    public function validatorData(Request $request, array $conditions) : \Illuminate\Http\JsonResponse | true
    {
        if (empty($request->all())) {
            return $this->responseJson(400, 'Formulario Vacio');
        }
        $validator = Validator::make($request->all(), $conditions);
        if ($validator->fails()) {
            return $this->responseJson(400, 'Error en la validación de los datos',null, $validator->errors());
        }
        return true;
    }
}
