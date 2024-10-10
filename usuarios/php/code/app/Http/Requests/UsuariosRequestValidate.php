<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequestValidate extends FormRequest
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

        $userId = ($this->isMethod('put') || $this->isMethod('patch')) ? ','.$this->route('id') : '';

        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'nombre'   => 'required',
                'apellido' => 'required',
                'email'    => 'required|email|unique:usuarios,email'.$userId,
                'clave'    => 'required',
                'type'     => 'required'
            ];
        }

        if ($this->isMethod('patch')) {
            return [
                'nombre'   => 'sometimes|required',
                'apellido' => 'sometimes|required',
                'email'    => 'sometimes|required|email|unique:usuarios,email'.$userId,
                'clave'    => 'sometimes|required',
                'type'     => 'sometimes|required'
            ];
        }

    }
}
