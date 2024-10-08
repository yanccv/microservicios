<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductosRequestValidate extends FormRequest
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

        ];

        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'producto'      => 'required',
                'precio'        => 'nullable|numeric',
                'categorias_id'   => 'required',
                'unidades_id'   => 'required'
            ];
        }

        if ($this->isMethod('patch')) {
            return [
                'producto'      => 'sometimes|required',
                'precio'        => 'sometimes|nullable|numeric',
                'categorias_id'   => 'sometimes|required',
                'unidades_id'   => 'sometimes|required'
            ];
        }
    }
}
