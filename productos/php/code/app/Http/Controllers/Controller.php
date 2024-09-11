<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class Controller
{
    public function responseJson(int $httpCode, string $message, $data = null, string $error = null)
    {
        $response = array_filter([
            'message' => $message,
            'data' => $data,
            'error' => $error,
            'status' => $httpCode
        ]);

        return response()->json($response, $httpCode);
    }

    public function validatorData(Request $request, array $conditions)
    {
        $validator = Validator::make($request->all(), $conditions);
        if ($validator->fails()) {
            return $this->responseJson(
                400,
                'Error en la validación de los datos',
                '',
                $validator->errors()
            );
        }
        return true;
    }

    public function destroyGeneral(Model $table, int $id)
    {
        try {
            $registerToRemove = $table::findOrFail($id);
            $registerToRemove->delete();
            return $this->responseJson(200, 'Registro eliminado');
            // return response()->json(['success' => true, 'message' => 'Registro eliminado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseJson(404, 'Registro No encontrado');
        } catch (\Throwable $th) {
            return $this->responseJson(500, 'Error al eliminar el registro', '', $th->getMessage());
        }
    }

}
