@extends('adminlte::page')

@section('title', 'Mascotas')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')

@stop

@section('content')

<div class="card card-primary">
    {!! Form::model($mascota, ['route'=>['admin.mascotas.update', $mascota], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">EDITAR MASCOTA </h1>
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
                    {{ Form::label('tipomascotaid', 'Tipo de mascota') }}
                    {!! Form::select('tipomascotaid', $tipo_mascotas, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tipomascotaid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
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

            <div class="col-md-6">
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
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.mascotas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
