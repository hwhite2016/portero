<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactanosMailable;


class ContactanosController extends Controller
{
    public function index(){
        return view('contactanos.index');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|min:8',
            'email'=>'required|email',
            'celular'=>'required',
        ]);

        $correo = new ContactanosMailable($request->all());
        Mail::to('porteroenlinea@gmail.com')->send($correo);

        return redirect()->route('contactanos.index')->with('info', 'El Correo fue enviado de forma Exitosa');
    }
}
