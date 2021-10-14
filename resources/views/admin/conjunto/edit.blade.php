@extends('adminlte::page')

@section('title', 'Conjuntos')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Barrio</h1> --}}
@stop

@section('content')
<br>
<div class="card card-primary">
    {!! Form::model($conjunto, ['route'=>['admin.conjuntos.update', $conjunto], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Conjunto</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">

            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Numero celular -->
                    {{ Form::label('conjuntocelular', '* Numero Celular Porteria') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        {{ Form::text('conjuntocelular', $conjunto->conjuntocelular, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}
                        @error('conjuntocelular')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Telefono -->
                    {{ Form::label('conjuntotelefono', 'Telefono Porteria') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        {{ Form::text('conjuntotelefono', null, array('placeholder' => '', 'class' => 'form-control')) }}
                        @error('conjuntotelefono')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="form-group"> <!-- Logo del conjunto -->
                    {{ Form::label('conjuntologo', 'Imagen del conjunto') }}
                    <img width="70px" src="/storage/{{ $conjunto->conjuntologo }}" alt="image">
                    {{ Form::file('conjuntologo', array('accept' => 'image/jpg,image/jpeg,image/png,image/svg', 'class' => 'form-control')) }}
                    @error('conjuntologo')
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
        <a class="btn btn-warning" href="{{route('admin.conjuntos.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
