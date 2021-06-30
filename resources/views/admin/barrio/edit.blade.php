@extends('adminlte::page')

@section('title', 'Barrios')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Editar Barrio</h1> --}}
@stop

@section('content')    
    
<div class="card card-primary">
    {!! Form::model($barrio, ['route'=>['admin.barrios.update', $barrio], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">EDITAR BARRIO</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group"> <!-- Ciudad -->
            {{ Form::label('ciudadid', 'Ciudad') }}
            {!! Form::select('ciudadid', $ciudads, $barrio->ciudadid, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione una ciudad']) !!}
        </div>

        <div class="form-group"> <!-- Nombre del barrio -->
            {{ Form::label('barrionombre', 'Nombre del barrio') }}
            {{ Form::text('barrionombre', $barrio->barrionombre, array('placeholder' => 'Ingresa un barrio', 'class' => 'form-control')) }} 
            @error('barrionombre')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror 
        </div>      

        <div class="form-group"> <!-- Estrato -->
            {{ Form::label('barrioestrato', 'Estrato') }}
            {!! Form::select('barrioestrato', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'], $barrio->barrioestrato, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.barrios.index')}}">Volver al listado de barrios</a></div>
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