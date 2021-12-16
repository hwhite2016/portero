@extends('adminlte::page_error')

@section('title', 'Registro')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    <div class='alert alert-default-primary alert-dismissible fade show' role='alert'>
        <i class="fas fa-info-circle"></i>&nbsp;
        Estimado usuario, a continuación encontrara un formulario donde podrá diligenciar los datos de las personas y mascotas que conviven en
        su casa o apartamento con el fin de actualizar el censo de la copropiedad, y que usted en su rol de propietario y/o residente, pueda comenzar a disfrutar
        de los beneficios que le ofrece su conjunto residencial a través de esta plataforma.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
@stop

@section('content')
<div class="card">
    {!! Form::model($registro, ['route'=>['registros.update', $registro], 'method'=>'put']) !!}
    @csrf
    <div class="card-header bg-light">
        <h1 class="card-title"><i class="far fa-file-alt"></i> <label>Formulario de registro</label></h1>
        {{ Form::hidden('registroid', $registro->registroid) }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group"> <!-- Conjunto -->
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la copropiedad']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Bloque -->
                    {{ Form::label('bloqueid', '* Bloque / Torre') }}
                    {!! Form::select('bloqueid', $bloques, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el bloque']) !!}
                    @error('bloqueid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Unidad -->
                    {{ Form::label('unidadid', '* Unidad') }}
                    {!! Form::select('unidadid', $unidads, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la unidad']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Tipo Propietario -->
                    {{ Form::label('tipopropietarioid', 'Tenedor') }}
                    {!! Form::select('tipopropietarioid', $tipo_propietarios, old('tipopropietarioid'), ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @if(!$propietario->count())
                    <small class="text-secondary">[Este campo sera diligenciado por la administración]</small>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Propietario -->
                    {{ Form::label('propietarioid', 'Nombre del Tenedor') }}
                    {!! Form::select('propietarioid', $propietario, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Agregue el nombre del tenedor']) !!}
                    @if(!$propietario->count())
                    <small class="text-secondary">[Este campo sera diligenciado por la administración]</small>
                    @endif
                    @error('propietarioid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            {{-- <div class="col-md-5">
                <div class="form-group">
                    {{ Form::label('parqueaderoid', 'Parqueaderos asignados') }}
                    {!! Form::select('parqueaderos[]', $parqueaderos, old('parqueaderos[]'), ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione los parqueaderos asignados', 'data-width'=>'100%']) !!}
                </div>
            </div> --}}

            <div class="col-md-5">
                <div class="form-group"> <!-- Parqueaderos -->
                    {{ Form::label('parqueaderoid', 'Parqueaderos asignados') }}
                    <div class="input-group">
                        {!! Form::select('parqueaderos[]', $parqueaderos, old('parqueaderos[]'), ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione los parqueaderos asignados', 'data-width'=>'72%']) !!}
                        @if($registro->estado_id != 3)
                        <div class="input-group-prepend">
                            {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
        <!-- /.Row -->

    </div>
    <!-- /.card-body -->
    @if($registro->estado_id != 3)
    {!! Form::close() !!}
    @endif
</div>
<!-- /.card -->
<a id="ancla"></a>

        @if($registro->estado_id != 3)
        <br>
        <div class="row">

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
                            @include('registro.indexResidente')
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-vehiculos" role="tabpanel" aria-labelledby="custom-tabs-four-vehiculos-tab">
                            @include('registro.indexVehiculo')
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-mascotas" role="tabpanel" aria-labelledby="custom-tabs-four-mascotas-tab">
                            @include('registro.indexMascota')
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.TAB -->

        </div>
        @endif

        @if($registro->estado_id != 3)
        <div class="card-footer">
            <a id="check"  class="btn btn-success"><i class="fas fa-spell-check"></i> &nbsp Enviar a revisión</a>
            <br><small class="text-secondary">[ Hacer click en este botón solo cuando haya finalizado todo el formulario ]</small>
        </div>
        <!-- /.card-footer -->
        @endif

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
        destino = $('a[id="ancla"]');
        $('html, body').animate({ scrollTop: destino.offset().top }, 500);

        $('#residentesModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var unidadid = button.data('whatever')
                var modal = $(this)
                var url = "{{ route('registros.createResidente', ":unidadid") }}";
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
                var url = "{{ route('registros.createVehiculo', ":unidadid") }}";
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
                var url = "{{ route('registros.createMascota', ":unidadid") }}"
                url = url.replace(':unidadid', unidadid)

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
        var txt = "{{session('info')}}";
        var msj = txt.toLowerCase().indexOf('error')
        if (msj >= 0){
            toastr.error("{{session('info')}}")
        }else{
            toastr.success("{{session('info')}}")
        }
    </script>

    <script>
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

    $('#check').click(function(e){
        e.preventDefault();

        Swal.fire({
          title: 'Antes de enviar el formulario, verifique que ha ingresado los datos solicitados.',
          text: "(Parqueaderos, residentes, vehiculos y mascotas.)",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Enviar a revisión',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            $(location).attr('href',"{{route('registros.estado', $registro->registroid)}}");
          }
        })
    });

 </script>
@stop
