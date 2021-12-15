@extends('adminlte::page')

@section('title', 'Organos de Control')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($organo, ['route'=>['admin.organos.update', $organo], 'method'=>'put']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Organo</label></h1>
        <span class="text-primary float-right"><a href="{{route('admin.empleados.create')}}"><i class="fas fa-user-plus"></i> Agregar colaborador</a></span>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Conjunto -->
                    {!! Form::label('conjuntoid', '* Conjunto') !!}
                    {!! Form::select('conjuntoid', $conjuntos, $organo->conjuntoid, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Nombre del Organo -->
                    {!! Form::label('organonombre', '* Nombre del Organo') !!}
                    @if(Auth::user()->hasRole('_superadministrador'))
                    {!! Form::text('organonombre', null, array('placeholder' => 'Ej: Consejo de Administración', 'class' => 'form-control')) !!}
                    @else
                    {!! Form::text('organonombre', null, array('disabled' => 'disabled', 'class' => 'form-control')) !!}
                    @endif
                    @error('organonombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Correo -->
                    {{ Form::label('organocorreo', '* Correo') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        {{ Form::email('organocorreo', null, array('placeholder' => 'Ej: pedro@gmail.com', 'class' => 'form-control')) }}

                    </div>
                    @error('organocorreo')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Numero celular -->
                    {{ Form::label('organocelular', 'Numero Celular') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        {{ Form::text('organocelular', null, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}

                    </div>
                    @error('organocelular')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Numero Telefono -->
                    {{ Form::label('organotelefono', 'Numero Telefono') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        {{ Form::text('organotelefono', null, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}

                    </div>
                    @error('organotelefono')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="form-group"> <!-- PQR -->
                    {{ Form::label('organopqr', 'Habilitar como agente PQR') }}
                    {!! Form::select('organopqr', ['0'=>'No','1'=>'SI'], null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('organopqr')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="form-group"> <!-- Estado -->
                    {{ Form::label('organoestado', 'Visible en el Home') }}
                    {!! Form::select('organoestado', ['0'=>'No','1'=>'SI'], null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('organoestado')
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
        <a class="btn btn-warning" href="{{route('admin.organos.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarOrgano']) !!}
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
    })
</script>
@stop
