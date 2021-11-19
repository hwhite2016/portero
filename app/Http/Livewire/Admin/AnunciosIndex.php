<?php

namespace App\Http\Livewire\Admin;

use App\Models\Conjunto;
use App\Models\Anuncio;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AnunciosIndex extends Component
{
    use WithPagination;
    public $search;
    public $sort = 'anuncionombre';
    public $direction = 'ASC';
    public $cant = 15;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
    	$this->resetPage();
    }

    public function render()
    {
        $anuncios = Anuncio::join("tipo_anuncios","tipo_anuncios.id", "=", "anuncios.tipoanuncioid")
            ->leftJoin('bloques', 'bloques.id', 'anuncios.bloqueid')
            ->select(Anuncio::raw('anuncios.id, anuncionombre, tipoanuncionombre, anunciofechaentrega, anuncioadjunto,anuncios.bloqueid,unidadid,bloquenombre'))
            ->whereIn('anuncios.conjuntoid', session('dependencias'))
            ->where(function ($query) {
                return $query->where('anuncionombre', 'LIKE', '%' . $this->search . '%')
                ->orwhere('tipoanuncionombre', 'LIKE', '%' . $this->search . '%')
                ->orwhere('anunciofechaentrega', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

            return view('livewire.admin.anuncios-index', compact('anuncios'));

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
        return redirect()->route('admin.anuncios.edit', $id );
    }


}
