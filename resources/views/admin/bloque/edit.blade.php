@extends('adminlte::page')

@section('title', 'Bloques')

@section('plugins.Select2', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($bloque, ['route'=>['admin.bloques.update', $bloque], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Bloque</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group"> <!-- Conjunto -->
                    {{ Form::label('conjuntoid', 'Conjunto') }}
                    {!! Form::select('conjuntoid', $conjuntos, $bloque->conjuntoid, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Bloque -->
                    {{ Form::label('bloquenombre', '* Nombre') }}
                    {{ Form::text('bloquenombre', null, array('placeholder' => 'Ej: Torre 1, Bloque 2, Etapa 3 ...', 'class' => 'form-control')) }}
                    @error('bloquenombre')
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
