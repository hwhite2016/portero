@extends('adminlte::page')

@section('title', 'Parqueaderos')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Parqueadero</h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::open(['route'=>'admin.parqueaderos.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title">CREAR NUEVO PARQUEADERO</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Conjunto -->
                    {!! Form::label('conjuntoid', 'Conjunto') !!}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
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
                    {!! Form::select('parqueaderopiso', ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el piso']) !!}
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
                    {!! Form::label('tipoparqueaderoid', 'Tipo de parqueadero') !!}
                    {!! Form::select('tipoparqueaderoid', $tipo_parqueaderos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo']) !!}
                    @error('tipoparqueaderoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Estado -->
                    {{ Form::label('estadoparqueaderoid', 'Estado') }}
                    {!! Form::select('estadoparqueaderoid', $estado_parqueaderos, null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('estadoparqueaderoid')
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









