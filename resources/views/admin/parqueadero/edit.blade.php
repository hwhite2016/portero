@extends('adminlte::page')

@section('title', 'Parqueaderos')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Editar Parqueadero</h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($parqueadero, ['route'=>['admin.parqueaderos.update', $parqueadero], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title">EDITAR PARQUEADERO</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Conjunto -->
                    {!! Form::label('conjuntoid', 'Conjunto') !!}
                    {!! Form::select('conjuntoid', $conjuntos, $parqueadero->conjuntoid, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Piso -->
                    {!! Form::label('parqueaderopiso', 'Numero del Piso') !!}
                    {!! Form::select('parqueaderopiso', ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10'], $parqueadero->parqueaderopiso, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el piso']) !!}
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Numero del Parqueadero -->
                    {!! Form::label('parqueaderonumero', 'Numero del Parqueadero') !!}
                    {!! Form::text('parqueaderonumero', null, array('placeholder' => 'Ej: 220, 301A ...', 'class' => 'form-control')) !!}
                    @error('parqueaderonumero')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Tipo -->
                    {!! Form::label('parqueaderotipo', 'Tipo de parqueadero') !!}
                    {!! Form::select('parqueaderotipo', ['Asignado'=>'Asignado', 'Visitante'=>'Visitante', 'Discapacitado'=>'Discapacitado'], $parqueadero->parqueaderotipo, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo']) !!}
                </div>
            </div>

            <div class="col-12 col-md-4">
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
        </div>
        <!-- /.row -->

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.parqueaderos.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarUnidad']) !!}
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

