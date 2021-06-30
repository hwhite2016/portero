@extends('adminlte::page')

@section('title', 'Personas')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Persona</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.personas.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVA PERSONA</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', 'Copropiedad') }}
                    {!! Form::select('conjuntos[]', $conjuntos, null, ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione la copropiedad asociada a la persona', 'data-width'=>'100%']) !!}
                    @error('conjuntos')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo Documento -->
                    {{ Form::label('tipodocumentoid', 'Tipo Documento') }}
                    {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo de documento']) !!}
                </div>
            </div>

            <div class="col-md-4">
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

            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('personafechanacimiento', 'Fecha de Nacimiento') }}

                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    {!! Form::text('personafechanacimiento', null, array('data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'yyyy/mm/dd', 'data-mask', 'class' => 'form-control')) !!}
                    </div>
                    @error('personafechanacimiento')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Correo -->
                    {{ Form::label('personacorreo', 'Correo') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        {{ Form::text('personacorreo', null, array('placeholder' => 'Ej: email@dominio.com', 'class' => 'form-control')) }}
                        @error('personacorreo')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('user', 1, true, ['class'=>'mr-1']) !!}
                        Generar usuario (2/200)
                    </label>
                </div>
            </div>

        </div>
        <!-- /.row -->

        @include('admin.user.partial.form')

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.personas.index')}}">Volver al listado de ciudades</a></div>
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

      $('#personafechanacimiento').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' });

      $(":input").inputmask();

    })
</script>
@stop
