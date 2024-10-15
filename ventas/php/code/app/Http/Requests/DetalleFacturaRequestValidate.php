<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleFacturaRequestValidate extends FormRequest
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
            'DetalleFactura'  => 'required|array|min:1',
            'DetalleFactura.*.productos_id' => 'required|integer',
            'DetalleFactura.*.cantidad' => 'required|integer||min:1',
        ];
    }


    public function messages()
    {
        return [
            'DetalleFactura' => 'La factura debe incluir algun producto.',
            'DetalleFactura.*.productos_id.required' => 'El necesario agregar un producto.',
            'DetalleFactura.*.productos_id.integer' => 'el id del producto debe ser un valor entero.',
            'DetalleFactura.*.cantidad.required' => 'El necesario agregar la cantidad producto.',
            'DetalleFactura.*.cantidad.integer' => 'la cantidad del debe ser un valor entero.',
        ];
    }
}
