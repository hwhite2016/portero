<?php

namespace App\Http\Livewire\Admin;

use App\Models\Residente;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ResidentesIndex extends Component
{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
    	$this->resetPage();
    }

    public function render()
    {
        $unidades = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
             ->join('conjuntos','conjuntos.id','=','bloques.conjuntoid')
             ->join('residentes','unidads.id','=','residentes.unidadid')
             ->leftJoin('vehiculos','unidads.id','=','vehiculos.unidadid')
             ->leftJoin('tipo_vehiculos','tipo_vehiculos.id','=','vehiculos.tipovehiculoid')
             ->join('personas','personas.id','=','residentes.personaid')
             ->join('tipo_residentes','tipo_residentes.id','=','residentes.tiporesidenteid')
             ->select('conjuntonombre','bloquenombre','unidadnombre', DB::raw("JSON_OBJECTAGG(concat(personadocumento,' - ', personanombre), tiporesidentenombre) AS residentes"), DB::raw("JSON_OBJECTAGG(coalesce(tipovehiculonombre,0), coalesce(vehiculoplaca,0)) AS vehiculos"))
             ->whereIn('conjuntos.id', session('dependencias'))
             ->where('unidads.unidadnombre', 'LIKE', '%' . $this->search . '%')
             ->orwhere('bloques.bloquenombre', 'LIKE', '%' . $this->search . '%')
             ->orwhere('personas.personanombre', 'LIKE', '%' . $this->search . '%')
             ->orwhere('personas.personadocumento', 'LIKE', '%' . $this->search . '%')
             ->orwhere('vehiculos.vehiculoplaca', 'LIKE', '%' . $this->search . '%')
             ->GroupByRaw('conjuntonombre, bloquenombre, unidadnombre')
             ->orderBy('bloquenombre', 'ASC')
             ->orderBy('unidadnombre', 'ASC')
             ->paginate();

        return view('livewire.admin.residentes-index', compact('unidades'));
        //with('roles:id,name')
    }
}
