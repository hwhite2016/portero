@extends('adminlte::page')

@section('title', 'Ciudads')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Ciudad</h1> --}}
@stop

@section('content')    
    
<div class="card card-primary">
    {!! Form::open(['route'=>'admin.ciudads.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVA CIUDAD</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group"> <!-- Pais -->
            {{ Form::label('paisid', 'Pais') }}
            {!! Form::select('paisid', $paises, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un pais']) !!}
        </div>

        <div class="form-group"> <!-- Nombre de la ciudad -->
            {{ Form::label('ciudadnombre', 'Nombre de la ciudad') }}
            {{ Form::text('ciudadnombre', null, array('placeholder' => 'Ingresa una ciudad', 'class' => 'form-control')) }} 
            @error('ciudadnombre')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>      

        <div class="form-group"> <!-- Codigo de la ciudad -->
            {{ Form::label('ciudadcodigo', 'Codigo de la ciudad') }}
            {{ Form::number('ciudadcodigo', null, array('placeholder' => 'Ingresa el codigo de la ciudad', 'class' => 'form-control')) }} 
            @error('ciudadcodigo')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>
        
        <div class="form-group"> <!-- Abreviatura de la ciudad -->
            {{ Form::label('ciudadabreviatura', 'Abreviatura de la ciudad') }}
            {{ Form::text('ciudadabreviatura', null, array('placeholder' => 'Ingresa el nombre de la ciudad abreviado', 'class' => 'form-control')) }} 
            @error('ciudadabreviatura')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>      
       
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.ciudads.index')}}">Volver al listado de ciudades</a></div>
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
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    })  
</script>
@stop