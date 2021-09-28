@extends('adminlte::page')

@section('title', 'Documentos')

@section('plugins.Select2', 'true')

@section('content_header')

@stop

@section('content')

<div class="card card-light">
    {!! Form::model($norma, ['route'=>['admin.normas.update', $norma], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">EDITAR DOCUMENTO</h1>
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

            <div class="col-12 col-md-3">
                <div class="form-group"> <!-- Tipo de documento -->
                    {!! Form::label('tiponorma_id', 'Tipo de documento') !!}
                    {!! Form::select('tiponorma_id', $tipo_normas, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo']) !!}
                    @error('tiponorma_id')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="form-group"> <!-- Nombre del documento -->
                    {!! Form::label('normanombre', 'Nombre del documento') !!}
                    {!! Form::text('normanombre', null, array('placeholder' => 'Reglamento de propiedad horizontal', 'class' => 'form-control')) !!}
                    @error('normanombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Adjunto -->
                    {{ Form::label('adjunto', 'Cargar documento') }} <small class="font-italic"> (Opcional)</small><br>
                    {{ Form::file('adjunto', array('accept' => 'application/pdf,image/jpg,image/jpeg,image/png,image/svg')) }}
                    <br>
                    @error('adjunto')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                    <br>
                    <small class="p-1">Max. 2MB</small> <small class="font-italic"> (Solo imagenes y archivos pdf)</small>

                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="form-group"> <!-- Ruta -->
                    {{ Form::label('ruta', 'Ruta del documento') }}
                    {!! Form::text('ruta', null, array('placeholder' => 'http://', 'class' => 'form-control')) !!}
                    @error('ruta')
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
        <a class="btn btn-warning" href="{{route('admin.normas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    })
</script>
@stop









