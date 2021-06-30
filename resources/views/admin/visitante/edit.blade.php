@extends('adminlte::page')

@section('title', 'Visitantes')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Editar Visitante</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::model($visitante, ['route'=>['admin.visitantes.update', $visitante], 'method'=>'put']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">EDITAR VISITANTE</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="form-group">
                    {{ Form::label('conjuntoid', 'Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    {{ Form::label('unidadid', 'Unidad') }}
                    {!! Form::select('unidadid', $unidads, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la vivienda']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Tipo Documento -->
                    {{ Form::label('tipodocumentoid', 'Tipo Documento') }}
                    {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo de documento']) !!}
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="form-group"> <!-- Documento ID -->
                    {{ Form::label('personadocumento', 'Documento ID') }}
                    {!! Form::text('personadocumento', null, array('placeholder' => 'Ingrese el No. de documento', 'class' => 'form-control')) !!}
                    @error('personadocumento')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group"> <!-- Nombres -->
                    {{ Form::label('personanombre', 'Nombres y Apellidos') }}
                    {!! Form::text('personanombre', null, array('placeholder' => 'Ej: Jose Perez Marquez', 'class' => 'form-control')) !!}
                    @error('personanombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group"> <!-- Numero celular -->
                    {{ Form::label('personacelular', 'Numero Celular') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        {{ Form::text('personacelular', null, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}
                        @error('personacelular')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Parqueadero -->
                    {{ Form::label('parqueaderoid', 'Asignar parqueadero') }}
                    {!! Form::select('parqueaderoid', $parqueaderos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un parqueadero disponible']) !!}
                    @error('parqueaderoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Observacion -->
                    {{ Form::label('visitanteobservacion', 'Observaciones') }}
                    {!! Form::textarea('visitanteobservacion', null, ['class' => 'form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('visitanteobservacion')
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
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.visitantes.index')}}">Volver al listado de visitantes</a></div>
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
      $('.select2').select2();

      $(":input").inputmask();

    })
</script>
@stop
