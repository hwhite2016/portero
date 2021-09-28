@extends('adminlte::page')

@section('title', 'vehiculos')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card card-primary">
    {!! Form::model($vehiculo, ['route'=>['admin.vehiculos.update', $vehiculo], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Recepción</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
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
                    {{ Form::label('unidadid', '* Unidad') }}
                    {!! Form::select('unidadid', $unidads, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la vivienda']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('tipovehiculoid', 'Tipo de vehiculo') }}
                    {!! Form::select('tipovehiculoid', $tipo_vehiculos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tipovehiculoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Marca -->
                    {{ Form::label('vehiculomarca', 'Marca') }}
                    {!! Form::text('vehiculomarca', null, array('placeholder' => 'Ej: Chevrolet Optra', 'class' => 'form-control')) !!}
                    @error('vehiculomarca')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Placa -->
                    {{ Form::label('vehiculoplaca', 'Placa') }}
                    {!! Form::text('vehiculoplaca', null, array('placeholder' => 'Ej: XYZ-999', 'class' => 'form-control', 'data-inputmask'=>'"mask": "AAA-999"')) !!}
                    @error('vehiculoplaca')
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
        <a class="btn btn-warning" href="{{route('admin.vehiculos.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
      $(":input").inputmask();

    })
</script>
@stop
