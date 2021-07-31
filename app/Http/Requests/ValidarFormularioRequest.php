<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarFormularioRequest extends FormRequest
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
            //Pais
            //Ciudad
            //Barrio
            //Conjuntos
            'conjuntonit' => 'required',
            'conjuntonombre' => 'required|min:3|max:30',
            'conjuntodireccion' => 'required|min:3|max:30',
            'conjuntocorreo' => 'required|email',
            //Bloques
        ];
    }

    public function messages()
    {
        return [
            //Pais
            //Ciudad
            //Barrio
            //Conjuntos
            //Conjuntos
            'conjuntonit.required'   => ':attribute es obligatorio.',
            'conjuntonombre.required'   => ':attribute es obligatorio.',
            'conjuntonombre.min'        => ':attribute debe contener mas de una letra.',
            'conjuntonombre.max'        => ':attribute debe contener max 30 letras.',
            'conjuntodireccion.required'   => ':attribute es obligatorio.',
            'conjuntodireccion.min'        => ':attribute debe contener mas de una letra.',
            'conjuntodireccion.max'        => ':attribute debe contener max 30 letras.',
            'conjuntocorreo.required'   => ':attribute es obligatorio.',
            'conjuntocorreo.email'        => ':attribute debe ser un correo válido.',
            //Bloques
        ];
    }

    public function attributes()
    {
        return [
            //Pais
            //Ciudad
            //Barrio
            //Conjuntos
            'conjuntonit'        => 'El NIT del conjunto',
            'conjuntonombre'        => 'El nombre del conjunto',
            'conjuntodireccion'    => 'La direccion del conjunto',
            'conjuntocorreo'    => 'El email',
            //Bloques
        ];
    }
}
