<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarRegistroRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'conjuntoid'=>'required',
            'bloqueid'=>'required',
            'unidadid'=>'required',
            'tipodocumentoid'=>'required',
            'personadocumento'=>'required|min:5|alpha_num',
            'personanombre'=>'required|min:3|max:50',
            'personacorreo'=>'required|email|max:50',
        ];
    }

    public function messages()
    {
        return [
            'conjuntoid.required'      => ':attribute es obligatorio.',
            'bloqueid.required'              => ':attribute es obligatorio.',
            'unidadid.required'           => ':attribute es obligatoria.',
            'personadocumento.required'   => ':attribute es obligatorio.',
            'personadocumento.min'        => ':attribute debe contener minimo 4 digitos.',
            'personadocumento.alpha_num'  => ':attribute debe contener solo letras o numeros.',
            'personanombre.required'   => ':attribute es obligatorio.',
            'personanombre.min'        => ':attribute debe contener minimo 3 caracteres.',
            'personanombre.max'        => ':attribute debe contener maximo 50 caracteres.',
            'personacorreo.required'   => ':attribute es obligatorio.',
            'personacorreo.email'      => ':attribute debe ser un correo valido.',
            'personacorreo.max'        => ':attribute debe contener maximo 50 caracteres.',
        ];
    }

    public function attributes()
    {
        return [
            'conjuntoid'        => 'El conjunto',
            'bloqueid'        => 'El bloque',
            'unidadid'      => 'La unidad',
            'personadocumento'  =>'El documento',
            'personanombre'     =>'El nombre',
            'personacorreo'     =>'El correo',
        ];
    }
}
