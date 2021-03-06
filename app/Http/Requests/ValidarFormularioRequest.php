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
            'conjuntonit' => 'required|min:4|max:20',
            'conjuntonombre' => 'required|min:3|max:30',
            'conjuntodireccion' => 'required|min:4|max:30',
            'conjuntounidades' => 'required',
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
            'conjuntonit.required'      => ':attribute es obligatorio.',
            'conjuntonit.min'           => ':attribute debe contener minimo 4 digitos.',
            'conjuntonit.max'           => ':attribute debe contener maximo 20 digitos.',
            'conjuntonombre.required'   => ':attribute es obligatorio.',
            'conjuntonombre.min'        => ':attribute debe contener mas de una letra.',
            'conjuntonombre.max'        => ':attribute debe contener max 30 letras.',
            'conjuntodireccion.required'   => ':attribute es obligatorio.',
            'conjuntounidades.required'   => ':attribute es obligatorio.',
            'conjuntodireccion.min'        => ':attribute debe contener mas de una letra.',
            'conjuntodireccion.max'        => ':attribute debe contener max 30 letras.',
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
            'conjuntounidades'    => 'El numero de unidades del conjunto',
            //Bloques
        ];
    }
}
