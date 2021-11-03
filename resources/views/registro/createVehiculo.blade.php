@extends('layouts/plantilla')


@section('content')

<div class="card card-primary">

    {{-- <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO VEHICULO</h1>
    </div> --}}
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-8">
                {!! Form::hidden('vehiculos', 1) !!}
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la copropiedad']) !!}
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('tipovehiculoid', '* Tipo de vehiculo') }}
                    {!! Form::select('tipovehiculoid', $tipo_vehiculos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tipovehiculoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Placa -->
                    {{ Form::label('vehiculoplaca', 'Placa') }}
                    {!! Form::text('vehiculoplaca', null, array('placeholder' => 'Ej: XYZ-999', 'class' => 'form-control', 'data-inputmask'=>'"mask": "AAA-999"', 'required')) !!}
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
</div>
<!-- /.card -->
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
