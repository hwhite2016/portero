<?php

namespace App\Http\Livewire\Admin;

use App\Models\Conjunto;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UnidadIndex extends Component
{
    use WithPagination;
    public $search;
    public $sort = 'estado_id';
    public $estado_id = [1,2,3,4];
    public $direction = 'DESC';
    public $cant = 15;
    public $bloqueid;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'estado_id' => ['except' => [1,2,3,4]]
    ];

    public function updatingSearch(){
    	$this->resetPage();
    }
    public function updatingEstado_id(){
    	$this->resetPage();
    }

    public function render()
    {
        $bloqueid = $this->bloqueid;
        $total_unidades = Conjunto::leftJoin('bloques','bloques.conjuntoid','conjuntos.id')
            ->leftJoin('unidads','unidads.bloqueid','bloques.id')
            ->select(DB::raw('count(unidads.id) as numunidades'), 'conjuntounidades as maxunidades')
            ->whereIn('conjuntos.id', session('dependencias'))
            ->GroupByRaw('conjuntounidades')
            ->first();

        $unidads = Unidad::leftjoin("residentes","residentes.unidadid", "=", "unidads.id")
                ->leftjoin("clase_unidads", "clase_unidads.id", "=", "unidads.claseunidadid")
                ->join("bloques","bloques.id", "=", "unidads.bloqueid")
                ->join("conjuntos","conjuntos.id", "=", "bloques.conjuntoid")
                ->join("estado_registros","estado_registros.id", "=", "unidads.estado_id")
                ->select(Unidad::raw('count(*) AS secuencia, count(residentes.id) as residente_count, unidads.id, unidads.bloqueid, conjuntonombre, bloques.bloquenombre, unidads.claseunidadid, clase_unidads.claseunidadnombre, clase_unidads.claseunidaddescripcion, unidadnombre, estado_id'))
                ->whereIn('bloques.conjuntoid', session('dependencias'))
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
                ->whereIn('estado_id', $this->estado_id)
                ->groupBy('unidads.id', 'unidads.bloqueid', 'conjuntonombre', 'bloques.bloquenombre', 'unidads.claseunidadid', 'clase_unidads.claseunidadnombre', 'clase_unidads.claseunidaddescripcion', 'unidadnombre', 'estado_id')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);

        $unidades = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
                ->whereIn('conjuntoid', session('dependencias'))
                ->count();

        $totales = Unidad::join('bloques','bloques.id','=','unidads.bloqueid')
                ->join('estado_registros', 'estado_registros.id', 'unidads.estado_id')
                ->select('estado_id', 'estadonombre', Unidad::raw('count(*) as cont') )
                ->whereIn('conjuntoid', session('dependencias'))
                ->groupBy('estado_id')->get();

        if ($bloqueid) {
            return view('livewire.admin.unidad-index', compact('unidads', 'bloqueid', 'total_unidades', 'unidades', 'totales'));
        }else{
            return view('livewire.admin.unidad-index', compact('unidads', 'total_unidades', 'unidades', 'totales'));
        }

    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
           if ($this->direction == 'ASC') {
                $this->direction = "DESC";
           } else {
                $this->direction = 'ASC';
           }
        } else {
            $this->sort = $sort;
            $this->direction = 'ASC';
        }


    }

    public function estado($estado)
    {
        $this->estado_id = [$estado];
    }

    public function edit($id)
    {
        return redirect()->route('admin.unidads.edit', $id );
    }
}
