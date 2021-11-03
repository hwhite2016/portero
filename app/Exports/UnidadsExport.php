<?php

namespace App\Exports;

use App\Models\Unidad;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnidadsExport implements FromCollection
{
    protected $texto;

    public function __construct(array $texto)
    {
        $this->texto = $texto['texto'];

    }
    public function collection()
    {

        $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
                ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
                ->join("bloques","bloques.id", "=", "unidads.bloqueid")
                ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
                ->join("estado_registros","estado_registros.id", "=", "unidads.estado_id")
                ->select('conjuntonombre', 'bloques.bloquenombre', 'unidadnombre', 'claseunidadnombre', 'claseunidaddescripcion', 'estadonombre')
                ->whereIn('bloques.conjuntoid', session('dependencias'))
                ->where(function ($query) {
                    if($this->texto){
                        return $query->where('unidads.unidadnombre', 'LIKE', '%' . $this->texto . '%')
                        ->orwhere('bloquenombre', 'LIKE', '%' . $this->texto . '%')
                        ->orwhere('claseunidadnombre', 'LIKE', '%' . $this->texto . '%')
                        ->orwhere('claseunidaddescripcion', 'LIKE', '%' . $this->texto . '%')
                        ->orwhere('estadonombre', 'LIKE', '%' . $this->texto . '%');
                    }
                })
                ->distinct()
                ->get();

        return $unidads;
    }
}
