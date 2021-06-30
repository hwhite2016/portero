<?php

namespace App\Http\Livewire\Admin;

use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RolesIndex extends Component
{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
    	$this->resetPage();
    }

    public function render()
    {
        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')->paginate();
        return view('livewire.admin.roles-index', compact('roles'));
    }
}
