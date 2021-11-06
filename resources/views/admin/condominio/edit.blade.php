@extends('adminlte::page')

@section('title', 'Condominios')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Barrio</h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($conjunto, ['route'=>['admin.condominios.update', $conjunto], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Conjunto</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group"> <!-- Barrio -->
                    {{ Form::label('barrioid', 'Barrio') }}
                    {!! Form::select('barrioid', $barrios, $conjunto->barrioid, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un barrio']) !!}
                    @error('barrioid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Nombre del conjunto -->
                    {{ Form::label('conjuntonombre', '* Nombre del conjunto') }}
                    {{ Form::text('conjuntonombre', $conjunto->conjuntonombre, array('placeholder' => 'Ingresa un conjunto', 'class' => 'form-control')) }}
                    @error('conjuntonombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Nit -->
                    {{ Form::label('conjuntonit', '* Nit') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                        </div>
                        {{ Form::number('conjuntonit', $conjunto->conjuntonit, array('placeholder' => 'Ingrese el NIT', 'class' => 'form-control')) }}
                        @error('conjuntonit')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group"> <!-- Numero de unidades -->
                    {{ Form::label('conjuntounidades', '* Nro. Unidades') }}
                    {{ Form::number('conjuntounidades', NULL, array('class' => 'form-control')) }}
                    @error('conjuntounidades')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Direccion del conjunto -->
                    {{ Form::label('conjuntodireccion', '* Direccion del conjunto') }}
                    {{ Form::text('conjuntodireccion', $conjunto->conjuntodireccion, array('placeholder' => 'Calle, Carrera, Transversal ..', 'class' => 'form-control')) }}
                    @error('conjuntodireccion')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Numero celular -->
                    {{ Form::label('conjuntocelular', 'Numero Celular Porteria') }}
                    {{ Form::text('conjuntocelular', $conjunto->conjuntocelular, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}
                    @error('conjuntocelular')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Telefono -->
                    {{ Form::label('conjuntotelefono', 'Telefono Porteria') }}
                    {{ Form::text('conjuntotelefono', $conjunto->conjuntotelefono, array('placeholder' => '', 'class' => 'form-control')) }}
                    @error('conjuntotelefono')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group"> <!-- Estado -->
                    {{ Form::label('conjuntoestado', 'Estado') }}
                    {!! Form::select('conjuntoestado', ['0'=>'Inactivo','1'=>'Activo'], $conjunto->conjuntoestado, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('conjuntoestado')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-7">
                <div class="form-group"> <!-- Logo del conjunto -->
                    {{ Form::label('conjuntologo', 'Logo del conjunto') }}
                    <img width="70px" src="/storage/{{ $conjunto->conjuntologo }}" alt="image">
                    {{ Form::file('conjuntologo', array('accept' => 'image/jpg,image/jpeg,image/png,image/svg', 'class' => 'form-control')) }}
                    @error('conjuntologo')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group"> <!-- Key -->
                    {{ Form::label('conjuntokey', 'Llave') }}
                    {{ Form::text('conjuntokey', $conjunto->conjuntokey, array('placeholder' => '', 'class' => 'form-control')) }}
                    @error('conjuntokey')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>



        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.condominios.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
      $(":input").inputmask();

      $( "#conjuntotelefono" ).focus(function() {
        if (!$("#conjuntotelefono").val()) $("#conjuntotelefono").val("+57 ");
      });
    })
</script>
@stop
