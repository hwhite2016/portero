<?php

namespace App\Http\Livewire\Admin;

use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithPagination;

class UnidadIndex extends Component
{
    use WithPagination;
    public $search;
    public $bloqueid;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
    	$this->resetPage();
    }

    public function render()
    {
        $bloqueid = $this->bloqueid;
        $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
                ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
                ->join("bloques","bloques.id", "=", "unidads.bloqueid")
                ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
                ->join("estado_registros","estado_registros.id", "=", "unidads.estado_id")
                ->select(Unidad::raw('count(residentes.id) as residente_count, unidads.id, unidads.bloqueid, conjuntonombre, bloques.bloquenombre, unidads.claseunidadid, clase_unidads.claseunidadnombre, clase_unidads.claseunidaddescripcion, unidadnombre, estado_id'))
                ->whereIn('bloques.conjuntoid', session('dependencias'))
                //->where('unidads.bloqueid', '=', $bloqueid)
                ->where(function($query) use ($bloqueid) {
                    if ($bloqueid) {
                        return $query->where('bloques.id', '=', $bloqueid);
                    }
                })
                ->where(function ($query) {
                    return $query->where('unidads.unidadnombre', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('bloquenombre', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('claseunidadnombre', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('claseunidaddescripcion', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('estadonombre', 'LIKE', '%' . $this->search . '%');
                })
                ->groupBy('unidads.id', 'unidads.bloqueid', 'conjuntonombre', 'bloques.bloquenombre', 'unidads.claseunidadid', 'clase_unidads.claseunidadnombre', 'clase_unidads.claseunidaddescripcion', 'unidadnombre', 'estado_id')
                ->orderBy('bloquenombre', 'ASC')
                ->orderBy('unidadnombre', 'ASC')
                ->paginate();

        if ($bloqueid) {
            return view('livewire.admin.unidad-index', compact('unidads', 'bloqueid'));
        }else{
            return view('livewire.admin.unidad-index', compact('unidads'));
        }

    }
}
