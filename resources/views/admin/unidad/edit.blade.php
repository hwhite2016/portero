@extends('adminlte::page')

@section('title', 'Unidades')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Unidad</h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($unidad, ['route'=>['admin.unidads.update', $unidad], 'method'=>'put']) !!}
    @csrf
    {{-- @method('PUT') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Unidad</label></h1>
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo inmueble -->
                    {{ Form::label('unidadnombre', '* Tipo de Inmueble / Numero') }}
                    {{ Form::text('unidadnombre', old('unidadnombre'), array('placeholder' => 'Ej: 106, 920, 1103 ... 2A, 4B, 5C ...', 'class' => 'form-control')) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo de Unidad -->
                    {{ Form::label('claseunidadid', '* Tipo de Unidad') }}
                    <div class="input-group">
                        {!! Form::select('claseunidadid', $clase_unidads, null, ['class' => 'form-control  select2','style'=>'width: 80%']) !!}
                        <div class="input-group-prepend">
                            <a href="#" id="addTipo" class="input-group-text" data-toggle="modal" data-target="#tipoModal" data-whatever="hola">
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

            <div class="col-md-3">
                <div class="form-group"> <!-- Tipo Propietario -->
                    {{ Form::label('tipopropietarioid', '* Tenedor') }}
                    {!! Form::select('tipopropietarioid', $tipo_propietarios, old('tipopropietarioid'), ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Propietario -->
                    {{ Form::label('propietarioid', '* Nombre del Tenedor') }}
                    <div class="input-group">
                        {!! Form::select('propietarioid', $propietario, null, ['class' => 'form-control select2','style'=>'width: 80%','data-placeholder'=>'Agregue el nombre del tenedor']) !!}
                        <div class="input-group-prepend">
                            <a href="#" id="delPropietario" class="input-group-text">
                                <i class="fas fa-minus"></i>
                            </a>
                        </div>
                        <div class="input-group-prepend">
                            <a href="#" id="addPropietario" class="input-group-text" data-toggle="modal" data-target="#propietarioModal" data-whatever="{{$unidad->id}}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    @error('propietarioid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
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
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarUnidad']) !!}
    </div>
    <!-- /.card-footer -->
    {!! Form::close() !!}
</div>
<!-- /.card -->

        <!-- TAB -->
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-residentes-tab" data-toggle="pill" href="#custom-tabs-four-residentes" role="tab" aria-controls="custom-tabs-four-residentes" aria-selected="true"><i class="fas fa-user"></i> Residentes ({{$residentes->count()}})</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-vehiculos-tab" data-toggle="pill" href="#custom-tabs-four-vehiculos" role="tab" aria-controls="custom-tabs-four-vehiculos" aria-selected="false"><i class="fas fa-car"></i> Vehiculos ({{$vehiculos->count()}})</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-mascotas-tab" data-toggle="pill" href="#custom-tabs-four-mascotas" role="tab" aria-controls="custom-tabs-four-mascotas" aria-selected="false"><i class="fas fa-paw"></i> Mascotas ({{$mascotas->count()}})</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-four-residentes" role="tabpanel" aria-labelledby="custom-tabs-four-residentes-tab">
                     @include('admin.residente.indexModal')
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-four-vehiculos" role="tabpanel" aria-labelledby="custom-tabs-four-vehiculos-tab">
                    @include('admin.vehiculo.indexModal')
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-four-mascotas" role="tabpanel" aria-labelledby="custom-tabs-four-mascotas-tab">
                    @include('admin.mascota.indexModal')
                 </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        <!-- /.TAB -->

<!-- Modal -->
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
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
{!! Form::open(['route'=>'admin.residentes.store', 'method'=>'post']) !!}
    @csrf
<div class="modal fade" id="propietarioModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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

<!-- Modal -->
{!! Form::open(['route'=>'admin.clase_unidads.store', 'method'=>'post']) !!}
    @csrf
<div class="modal fade" id="tipoModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
        $(":input").inputmask();

        $('#delPropietario').on('click', function () {
            //console.log($('#propietarioid').val());

            $('#propietarioid option').each(function() {
                    $(this).remove();
            });
        })

        $('#tipoModal').on('show.bs.modal', function (event) {
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

        $('#propietarioModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var unidadid = button.data('whatever')
            var modal = $(this)
            var url = "{{route('admin.unidads.getModal', ":unidadid") }}";
            url = url.replace(':unidadid', unidadid);

            $.ajax({
                async: true,
                url: url,
                type: 'GET',
                dataType: "html",
                success: function (data) {
                    modal.find('.modal-title').text('Asignar Tenedor')
                    modal.find('.modal-body').html(data)
                },
                error: function (error) {
                    funError(error);
                }
            })

        })

        $('#residentesModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var unidadid = button.data('whatever')
                var modal = $(this)
                var url = "{{ route('admin.residentes.createModal', ":unidadid") }}";
                url = url.replace(':unidadid', unidadid);

                $.ajax({
                    async: true,
                    url: url,
                    type: 'GET',
                    dataType: "html",
                    success: function (data) {
                        modal.find('.modal-title').text('Crear nuevo Residente')
                        modal.find('.modal-body').html(data)
                    },
                    error: function (error) {
                        funError(error);
                    }
                })
        })

        $('#vehiculosModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var unidadid = button.data('whatever')
                var modal = $(this)
                var url = "{{ route('admin.vehiculos.createModal', ":unidadid") }}";
                url = url.replace(':unidadid', unidadid);

                $.ajax({
                    async: true,
                    url: url,
                    type: 'GET',
                    dataType: "html",
                    success: function (data) {
                        modal.find('.modal-title').text('Crear nuevo Vehiculo')
                        modal.find('.modal-body').html(data)

                    },
                    error: function (error) {
                        funError(error);
                    }
                })
        })

        $('#mascotasModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var unidadid = button.data('whatever')
                var modal = $(this)
                var url = "{{ route('admin.mascotas.createModal', ":unidadid") }}";
                url = url.replace(':unidadid', unidadid);

                $.ajax({
                    async: true,
                    url: url,
                    type: 'GET',
                    dataType: "html",
                    success: function (data) {
                        modal.find('.modal-title').text('Crear nueva Mascota')
                        modal.find('.modal-body').html(data)
                    },
                    error: function (error) {
                        funError(error);
                    }
                })
        })


    })
</script>

@if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")

        var cadena = "{{session('info')}}";
        var residente = cadena.toLowerCase().indexOf('residente')
        var vehiculo = cadena.toLowerCase().indexOf("vehiculo")
        var mascota = cadena.toLowerCase().indexOf('mascota')
        if (residente >= 0){
            $("#custom-tabs-four-residentes").addClass("show active")
            $("#custom-tabs-four-vehiculos").removeClass("show active")
            $("#custom-tabs-four-residentes-tab").addClass("active")
            $("#custom-tabs-four-vehiculos-tab").removeClass("active")
        }else if (vehiculo >= 0){
            $("#custom-tabs-four-residentes").removeClass("show active")
            $("#custom-tabs-four-vehiculos").addClass("show active")
            $("#custom-tabs-four-residentes-tab").removeClass("active")
            $("#custom-tabs-four-vehiculos-tab").addClass("active")
        }else if (mascota >= 0){
            $("#custom-tabs-four-residentes").removeClass("show active")
            $("#custom-tabs-four-mascotas").addClass("show active")
            $("#custom-tabs-four-residentes-tab").removeClass("active")
            $("#custom-tabs-four-mascotas-tab").addClass("active")
        }

    </script>
@endif
<script>
    $('.frm_delete').submit(function(e){
        e.preventDefault();

        Swal.fire({
          title: 'Esta usted seguro de eliminar este registro?',
          text: "Esta accion no se podra deshacer!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit();
          }
        })
    });

 </script>
@stop
