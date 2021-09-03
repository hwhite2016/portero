<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\InvitadosImport;
use Illuminate\Http\Request;

use Excel;

class InvitadoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:admin.invitados.index')->only('index');
        $this->middleware('can:admin.invitados.create')->only('create', 'store', 'restaurar');
        $this->middleware('can:admin.invitados.edit')->only('edit', 'update');
        $this->middleware('can:admin.invitados.destroy')->only('destroy', 'hdestroy');
    }

    public function importForm(){
        return view('admin.invitado.import');
    }

    public function import(Request $request)
    {

        $import = new InvitadosImport();
        Excel::import($import, request()->file('invitados'));
        return view('admin.invitado.import', ['numRows'=>$import->getRowCount()]);
    }
}
