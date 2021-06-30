@extends('adminlte::page')

@section('title', 'Tipo de unidades')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Tipo</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.clase_unidads.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO TIPO DE UNIDAD</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            <div class="col-12">
                <div class="form-group"> <!-- Conjunto -->
                    {{ Form::label('conjuntoid', 'Conjunto') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Nombre del Tipo -->
                    {{ Form::label('claseunidadnombre', 'Nombre del tipo de unidad') }}
                    {{ Form::text('claseunidadnombre', null, array('placeholder' => 'Ej: Tipo A, Tipo B, Clase C ...', 'class' => 'form-control')) }}
                    @error('claseunidadnombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Descripcion -->
                    {{ Form::label('claseunidaddescripcion', 'Descripcion') }}
                    {{ Form::text('claseunidaddescripcion', null, array('placeholder' => 'Ej: 75 mts, 90 mts, 120 mts ...', 'class' => 'form-control')) }}
                    @error('claseunidaddescripcion')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Cuota de Administracion -->
                    {{ Form::label('claseunidadcuota', 'Cuota de Administración') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        {{ Form::text('claseunidadcuota', null, array('placeholder' => '', 'class' => 'form-control')) }}
                    </div>
                    @error('claseunidadcuota')
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
        <a class="btn btn-warning" href="{{route('admin.clase_unidads.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
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
    Inputmask.extendAliases({
    pesos: {
                prefix: "",
                groupSeparator: ".",
                alias: "numeric",
                placeholder: "0",
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                clearMaskOnLostFocus: false
            }
    });
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();

      //$("input").inputmask();
      $("#claseunidadcuota").inputmask({ alias : "pesos" });
    })
</script>
@stop









