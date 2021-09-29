@extends('adminlte::page')

@section('title', 'Empleados')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card card-primary">
    {!! Form::model($empleado, ['route'=>['admin.empleados.update', $empleado], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title">EDITAR COLABORADOR </h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Estructura -->
                    {{ Form::label('organo_id', 'Estructura') }}
                    {!! Form::select('organo_id', $organos, null, ['class' => 'form-control  select2', 'style'=>'width: 100%','data-placeholder'=>'Seleccione la estructura']) !!}
                    @error('organo_id')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Cargo -->
                    {{ Form::label('cargo_id', 'Cargo') }}
                    {!! Form::select('cargo_id', $cargos, null, ['class' => 'form-control  select2', 'style'=>'width: 100%','data-placeholder'=>'Seleccione el cargo']) !!}
                    @error('cargo_id')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Correo -->
                    {{ Form::label('empleadocorreo', 'Correo Laboral') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        {{ Form::email('empleadocorreo', null, array('placeholder' => 'Ej: comite_convivencia@gmail.com', 'class' => 'form-control')) }}

                    </div>
                    @error('empleadocorreo')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Estado -->
                    {{ Form::label('empleadoestado', 'Estado') }}
                    {!! Form::select('empleadoestado', ['0'=>'Inactivo','1'=>'Activo'], null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('empleadoestado')
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
        <a class="btn btn-warning" href="{{route('admin.empleados.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
      $('.select2').select2();

    })
</script>
@stop
