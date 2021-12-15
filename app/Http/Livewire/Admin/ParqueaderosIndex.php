<?php

namespace App\Http\Livewire\Admin;

use App\Models\Parqueadero;
use Livewire\Component;
use Livewire\WithPagination;

class ParqueaderosIndex extends Component
{
    use WithPagination;
    public $search;
    public $sort = 'parqueaderonumero';
    public $direction = 'ASC';
    public $cant = 15;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
    	$this->resetPage();
    }

    public function render()
    {
        $parqueaderos = Parqueadero::join("tipo_parqueaderos","tipo_parqueaderos.id", "=", "parqueaderos.tipoparqueaderoid")
            ->join("estado_parqueaderos","estado_parqueaderos.id", "=", "parqueaderos.estadoparqueaderoid")
            ->leftJoin('unidads_parqueaderos', 'parqueadero_id', 'parqueaderos.id')
            ->leftJoin('unidads', 'unidads.id', 'unidad_id')
            ->select(Parqueadero::raw('parqueaderos.id, tipoparqueaderonombre, parqueaderonumero, parqueaderopiso, estadoparqueaderonombre, unidadnombre'))
            ->whereIn('parqueaderos.conjuntoid', session('dependencias'))
            ->where(function ($query) {
                return $query->where('parqueaderonumero', 'LIKE', '%' . $this->search . '%')
                ->orwhere('tipoparqueaderonombre', 'LIKE', '%' . $this->search . '%')
                ->orwhere('parqueaderopiso', 'LIKE', '%' . $this->search . '%')
                ->orwhere('estadoparqueaderonombre', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

            return view('livewire.admin.parqueaderos-index', compact('parqueaderos'));
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

    public function edit($id)
    {
        return redirect()->route('admin.parqueaderos.edit', $id );
    }

}
