<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaRequestValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'Factura.usuarios_id' => 'required'
        ];

        // return [
        //     'usuarios_id' => 'required|integer',
        //     'productos.*.productos_id' => 'required|integer',
        //     'productos.*.cantidad' => 'required|integer',
        //     // Nueva regla para validar que el array 'productos' no esté vacío
        //     'productos' => 'required|array|min:1',
        // ];
    }
}
