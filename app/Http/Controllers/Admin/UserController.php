<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conjunto;
use Spatie\Permission\Models\Role;
use App\Models\RolesConjunto;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.create')->only('create', 'store');
        $this->middleware('can:admin.users.edit')->only('edit', 'update');
        $this->middleware('can:admin.users.destroy')->only('destroy');
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function create()
    {
        $roles = Role::all();
        //$conjuntos = Conjunto::all()->pluck('conjuntonombre', 'id');
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        //$user = User::create($request->all());
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')->with('info', 'El usuario se creo de forma exitosa.');
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        //$conjuntos = Conjunto::all()->pluck('conjuntonombre', 'id');

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        //$user->conjuntos()->sync($request->conjuntos);
        return redirect()->route('admin.users.edit', $user)->with('info', 'Los roles fueron asignados de forma exitosa.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('info', 'El usuario se eliminó exitosamente.');
    }
}
