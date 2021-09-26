@extends('adminlte::page')

@section('title', 'Bloques')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Bloque</h1> --}}
@stop

@section('content')
<br>
<div class="card card-primary">
    {!! Form::open(['route'=>'admin.bloques.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title">CREAR NUEVO BLOQUE/TORRE</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
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
            <div class="col-md-12">
                <div class="form-group"> <!-- Bloque -->
                    <div class="row row-cols-3">
                        <div class="col">
                            {{ Form::label('tipobloqueid', 'Tipo') }}
                            {!! Form::select('tipobloqueid', $tipo_bloques, null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                        </div>
                        <div class="col">
                            {{ Form::label('tipobloqueid2', '* Nombre / Numero') }}
                            {{ Form::text('bloquenombre', null, array('placeholder' => 'Ej: 1, 2, 3 ... A, B, C ...', 'class' => 'form-control')) }}
                            @error('bloquenombre')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.bloques.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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









