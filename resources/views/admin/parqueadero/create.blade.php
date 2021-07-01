@extends('adminlte::page')

@section('title', 'Parqueaderos')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Parqueadero</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.parqueaderos.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO PARQUEADERO</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group"> <!-- Conjunto -->
            {!! Form::label('conjuntoid', 'Conjunto') !!}
            {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
            @error('conjuntoid')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>

        <div class="form-group"> <!-- Numero -->
            {!! Form::label('parqueaderonumero', 'Numero') !!}
            {!! Form::text('parqueaderonumero', null, array('placeholder' => 'Ej: 220, 301A ...', 'class' => 'form-control')) !!}
            @error('parqueaderonumero')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>

        <div class="form-group"> <!-- Piso -->
            {!! Form::label('parqueaderopiso', 'Numero del Piso') !!}
            {!! Form::select('parqueaderopiso', ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el piso']) !!}
        </div>

        <div class="form-group"> <!-- Tipo -->
            {!! Form::label('parqueaderotipo', 'Tipo de parqueadero') !!}
            {!! Form::select('parqueaderotipo', ['Asignado', 'Visitante', 'Discapacitado'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo']) !!}
        </div>

        <div class="form-group"> <!-- Estado -->
            {{ Form::label('parqueaderoestado', 'Estado') }}
            {!! Form::select('parqueaderoestado', ['0'=>'Disponible','1'=>'Ocupado'], null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
            @error('parqueaderoestado')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.parqueaderos.index')}}">Volver al listado de parqueaderos</a></div>
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








