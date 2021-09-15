@extends('adminlte::page')

@section('title', 'Unidades')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Unidad</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.unidads.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVA UNIDAD</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group"> <!-- Bloque -->
                    {{ Form::label('bloqueid', '* Bloque / Torre / Etapa / Manzana') }}
                    {!! Form::select('bloqueid', $bloques, old('bloqueid'), ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un bloque']) !!}
                </div>
            </div>

            <div class="col-4">
                <div class="form-group"> <!-- Tipo Unidad -->
                    {{ Form::label('tipounidadid', 'Tipo de inmueble') }}
                    {!! Form::select('tipounidadid', $tipo_unidads, old('tipounidadid'), ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                </div>
            </div>

            <div class="col-4">
                <div class="form-group"> <!-- Numero Unidad -->
                    {{ Form::label('unidadnombre', '* Numero') }}
                    {{ Form::text('unidadnombre', old('unidadnombre'), array('placeholder' => 'Ej: 106, 920, 1103 ... 2A, 4B, 5C ...', 'class' => 'form-control')) }}
                    @error('unidadnombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Categoria de Unidad -->
                    {{ Form::label('claseunidadid', '* Tipo de Unidad') }}
                    <div class="input-group">
                        {!! Form::select('claseunidadid', $clase_unidads, null, ['class' => 'form-control  select2','style'=>'width: 90%']) !!}
                        <div class="input-group-prepend">
                            <a href="#" id="addTipo" class="input-group-text" data-toggle="modal" data-target="#exampleModal" data-whatever="tpr">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    @error('claseunidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group"> <!-- Parqueaderos asignados -->
                    {{ Form::label('parqueaderoid', 'Parqueaderos asignados') }}
                    {!! Form::select('parqueaderos[]', $parqueaderos, old('parqueaderos[]'), ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione los parqueaderos asignados', 'data-width'=>'100%']) !!}
                </div>
            </div>
        </div>
        <!-- /.row-->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        @if($bloqueid)
            <a class="btn btn-warning" href="{{route('admin.unidads.show', $bloqueid)}}"><i class="fas fa-angle-double-left"></i> Volver</a>
        @else
            <a class="btn btn-warning" href="{{route('admin.unidads.index')}}"><i class="fas fa-angle-double-left"></i> Volver</a>
        @endif
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
    </div>
    <!-- /.card-footer -->
    {!! Form::close() !!}
</div>
<!-- /.card -->

<!-- Modal -->
{!! Form::open(['route'=>'admin.clase_unidads.store', 'method'=>'post']) !!}
    @csrf
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>
{!! Form::close() !!}

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

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var modal = $(this)

            $.ajax({
                async: true,
                url: "{{route('admin.clase_unidads.getModal')}}",
                type: 'GET',
                dataType: "html",
                success: function (data) {
                    modal.find('.modal-title').text('Tipo de unidad')
                    modal.find('.modal-body').html(data)
                },
                error: function (error) {
                    funError(error);
                }
            })

        })


    })
</script>
@stop










