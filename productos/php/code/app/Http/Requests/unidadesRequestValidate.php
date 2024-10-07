<?php

namespace App\Http\Requests;

use App\Utilities\JsonResponseCustom;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class unidadesRequestValidate extends FormRequest
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
        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'nombre'    => 'required',
                'siglas'    => 'required',
                // 'estatus'   => 'required'
            ];
        }

        if ($this->isMethod('patch')) {
            return [
                'nombre'    => 'sometimes|required',
                'siglas'    => 'sometimes|required',
                // 'estatus'   => 'sometimes|required'
            ];
        }
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la unidad es obligatorio.',
            'siglas.required' => 'Las siglas son obligatorias.',
        ];
    }

}
