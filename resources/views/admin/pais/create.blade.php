@extends('adminlte::page')

@section('title', 'Paises')

@section('content_header')

@stop

@section('content')    
    
<div class="card card-primary">
    {!! Form::open(['route'=>'admin.pais.store', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO PAIS</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group"> <!-- Nombre del pais -->
            {{ Form::label('paisnombre', 'Nombre del pais') }}
            {{ Form::text('paisnombre', old('paisnombre'), array('placeholder' => 'Ej: Colombia', 'class' => 'form-control')) }} 
            @error('paisnombre')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>

        <div class="form-group"> <!-- Codigo del Pais -->
            {{ Form::label('paiscodigo', 'Codigo del pais') }}
            {{ Form::number('paiscodigo', null, array('placeholder' => 'Ej: 57', 'class' => 'form-control')) }} 
            @error('paiscodigo')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>

        <div class="form-group"> <!-- Abreviatura del Pais-->
            {{ Form::label('paisabreviatura', 'Abreviatura del pais') }}
            {{ Form::text('paisabreviatura', null, array('placeholder' => 'Ej: COL', 'class' => 'form-control')) }} 
            @error('paisabreviatura')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>

        <div class="form-group"> <!-- Bandera del Pais -->
            {{ Form::label('paisbandera', 'Bandera del pais') }}
            {{ Form::file('paisbandera', array('accept' => 'image/jpeg,image/png', 'class' => 'form-control')) }} 
            @error('paisbandera')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.pais.index')}}">Volver al listado de paises</a></div>
            <div class="col-2 col-sm-1">
                {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
            </div>
            <div class="col-2 col-sm-1">
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    <!-- /.card-footer -->  
    {!! Form::close() !!}
</div>
<!-- /.card -->
@stop

@section('footer') 
    @include('admin.partial.footer') 
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')

@stop
