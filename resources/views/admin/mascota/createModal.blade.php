@extends('layouts/plantilla')


@section('content')

<div class="card card-primary">

    {{-- <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVA MASCOTA</h1>
    </div> --}}
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-8">
                {!! Form::hidden('mascotas', 1) !!}
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

            <div class="col-md-3">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('tipomascotaid', '* Tipo de mascota') }}
                    {!! Form::select('tipomascotaid', $tipo_mascotas, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tipomascotaid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Nombre -->
                    {{ Form::label('mascotanombre', 'Nombre') }}
                    {!! Form::text('mascotanombre', null, array('class' => 'form-control')) !!}
                    @error('mascotanombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Raza -->
                    {{ Form::label('mascotaraza', 'Raza') }}
                    {!! Form::text('mascotaraza', null, array('placeholder' => 'Ej: Pitbull, Labrador ...', 'class' => 'form-control')) !!}
                    @error('mascotaraza')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Edad -->
                    {{ Form::label('mascotaedad', 'Edad') }}
                    {!! Form::number('mascotaedad', null, array('placeholder' => 'Edad en meses', 'class' => 'form-control')) !!}
                    @error('mascotaedad')
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

    })
</script>
@stop
