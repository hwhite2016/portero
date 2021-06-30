<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UsersCreate extends Component
{
    public $open = true;

    public function render()
    {
        return view('livewire.admin.users-create');
    }
}
