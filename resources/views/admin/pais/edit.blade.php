@extends('adminlte::page')

@section('title', 'Paises')

@section('content_header')

@stop

@section('content')

<div class="card card-primary">
    {!! Form::model($pais, ['route'=>['admin.pais.update', $pais], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">EDITAR PAIS</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group"> <!-- Nombre del pais -->
            {{ Form::label('paisnombre', 'Nombre del pais') }}
            {{ Form::text('paisnombre', $pais->paisnombre, array('placeholder' => 'Ej: Colombia', 'class' => 'form-control')) }}
            @error('paisnombre')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>

        <div class="form-group"> <!-- Codigo del Pais -->
            {{ Form::label('paiscodigo', 'Codigo del pais') }}
            {{ Form::number('paiscodigo', $pais->paiscodigo, array('placeholder' => 'Ej: 57', 'class' => 'form-control')) }}
            @error('paiscodigo')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>

        <div class="form-group"> <!-- Abreviatura del Pais-->
            {{ Form::label('paisabreviatura', 'Abreviatura del pais') }}
            {{ Form::text('paisabreviatura', $pais->paisabreviatura, array('placeholder' => 'Ej: COL', 'class' => 'form-control')) }}
            @error('paisabreviatura')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>

        <div class="form-group"> <!-- Bandera del Pais -->
            {{ Form::label('paisbandera', 'Bandera del pais') }}
            <img width="40px" src="/storage/{{ $pais->paisbandera }}" alt="image">
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
@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')

@stop
