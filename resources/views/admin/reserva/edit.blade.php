@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')
@section('plugins.Toastr', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')

{{-- @php
    $fch = []
@endphp
@endphp
@foreach ($fechas as $fecha)
    @php
    $fch[] = $fecha['fecha']
    @endphp
@endforeach --}}

<br>
<div class="card">
    {!! Form::open(['route'=>'admin.reservas.carrito', 'method'=>'post']) !!}
    @csrf

    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Nueva Reserva</label>
        </h1>
        @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="far fa-calendar-check"></i> &nbsp Ver reservas</a>
        @endcan
        <a class="btn btn-warning float-right mr-2" href="{{route('admin.zonas.index')}}"><i class="fas fa-angle-double-left"></i></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-default-primary alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{-- <h5><i class="fas fa-info-circle"></i> Información:</h5> --}}
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <b>Aforo máximo:</b> {{$zonareserva->zonaaforomax}} Personas
                        </div>
                        <div class="col-12 col-md-3">
                            <b>Cupo máximo por vivienda:</b> {{$zonareserva->zonacuporeservamax}} Personas
                        </div>
                        <div class="col-12 col-md-3">
                            <b>Tiempo de antelación Max.:</b> {{$zonareserva->zonatiemporeservamax}} Días
                        </div>
                        <div class="col-12 col-md-3">
                            <b>No. de franjas a reservar Max.:</b> {{$zonareserva->zonareservadiariamax}}
                        </div>
                        <div class="col-12 col-md-3">
                            <b>Duracion de la franja:</b> {{$zonareserva->zonafranjatiempo}} Hora(s)
                        </div>
                        <div class="col-12 col-md-3">
                            <b>Valor por franja:</b> ${{$zonareserva->zonaprecio}} COP
                        </div>
                        <div class="col-12 col-md-3">
                            <i class="fas fa-ban text-danger"></i> No disponible
                        </div>



                    </div>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <div class="form-group"> <!-- Unidad -->
                    {!! Form::label('unidadid', 'Unidad') !!}
                    {!! Form::select('unidadid', $unidad, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la unidad']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="form-group"> <!-- Zona -->
                    {!! Form::label('zonaid', 'Zona Comun') !!}
                    {!! Form::select('zonaid', $zona, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la zona']) !!}
                    @error('zonaid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-2">
                <div class="form-group"> <!-- Cupos -->
                    {!! Form::label('reservacupos', 'Cupos') !!}
                    {!! Form::select('reservacupos', [], null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('reservacupos')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            @if($zonareserva->zonacompartida == 1)

                <div class="col-12 col-md-3">
                    <div class="form-group"> <!-- Fecha -->
                        {{ Form::label('fecha', 'Fecha') }}
                        <div class="input-group date" id="fecha2" data-target-input="nearest">
                            {!! Form::text('fecha', null, array('data-toggle' => 'datetimepicker','data-target' => '#fecha2', 'class' => 'form-control datetimepicker-input')) !!}
                            <div class="input-group-append" data-target="#fecha2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                            </div>
                        </div>
                        @error('fecha')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>

            @else

                <div class="col-12 col-md-3">
                    <div class="form-group"> <!-- Fecha -->
                        {{ Form::label('fecha', 'Fecha y hora de inicio') }}
                        <div class="input-group date" id="fecha3" data-target-input="nearest">
                            {!! Form::text('fecha', null, array('data-toggle' => 'datetimepicker','data-target' => '#fecha3', 'class' => 'form-control datetimepicker-input')) !!}
                            <div class="input-group-append" data-target="#fecha3" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                            </div>
                        </div>
                        @error('fecha')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <div class="form-group"> <!-- Numero horas -->
                        {!! Form::label('franja', 'Franjas a reservar') !!}
                        {!! Form::select('franja', [], null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                        @error('franja')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>

            @endif

        </div>
        <!-- /.row -->
        <p></p>
        <div class="col-md-10">
            <div class="row" id="disponibilidad"></div>


        </div>
    </div>
    <!-- /.card-body -->
    @if($zonareserva->zonacompartida == 0)
        <div class="card-footer">
            <a class="btn btn-warning" href="{{route('admin.zonas.index')}}"><i class="fas fa-angle-double-left"></i> Volver</a>

            {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
            {!! Form::submit('Generar reserva', ['class'=>'btn btn-primary']) !!}
        </div>
        <!-- /.card-footer -->
        {!! Form::close() !!}
    @endif
</div>
<!-- /.card -->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

@stop

@section('js')


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
@endif

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        var fechas = @json($fechas);
        var disvar = [];
        fechas.forEach(element => {
            //console.log(element.fecha);
            disvar.push (moment(element.fecha));

        });

        var zc = {{$zonareserva->zonacompartida}};
        var iter = 1;
        if(zc == 0) iter = {{$zonareserva->zonacuporeservamax}};
        for (var i = iter; i <= {{$zonareserva->zonacuporeservamax}}; i++) {
            $('#reservacupos').append('<option value="'+ i +'">'+ i +'</option>');
        }

        $('#fecha2').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment().subtract(1, 'days'),
            disabledDates: [
                moment().subtract(1, 'days')
            ],
            maxDate: moment().add({{$zonareserva->zonatiemporeservamax + 1}}, 'days')
        })

        $('#fecha3').datetimepicker({
            format: 'YYYY-MM-DD hh:mm A',
            stepping: 60,
            collapse: false,
            //sideBySide: true,
            locale: 'es',
            icons: { time: 'fas fa-clock' },
            minDate: moment().subtract(1, 'days'),
            //enabledHours: [9, 10, 11, 12, 13, 14, 15, 16],
            enabledDates: [
                //moment().subtract(1, 'days'),
                disvar[0],disvar[1],disvar[2],disvar[3],disvar[4],disvar[5],disvar[6]
            ],

            maxDate: moment().add({{$zonareserva->zonatiemporeservamax}}, 'days')
        })

        $('#fecha3').on('keypress', function(e){
            e.preventDefault();
        })

        $('#fecha3').on('keydown', function (e){
            try {
                if ((e.keyCode == 8 || e.keyCode == 46))
                    return false;
                else
                    return true;
            }
            catch (Exception)
            {
                return false;
            }
        });

        $("#zonaid").on('change', function(e) {
            $('#disponibilidad').html('');
            $('#fecha').val('');
            //$('#fecha2').datetimepicker('clear');

            var id = $( "#zonaid" ).val();
            var url = "{{ route('admin.reservas.cupo', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $("#reservacupos").empty();
                    //$('#reservacupos').append('<option value="">seleccione el cupo</option>');
                    for (var i = 1; i <= data.cupo.zonacuporeservamax; i++) {
                        $('#reservacupos').append('<option value="'+ i +'">'+ i +'</option>');
                    }

                    // $('#fecha2').datetimepicker('destroy');
                    // $('#fecha2').datetimepicker({
                    //     format: 'YYYY-MM-DD',
                    //     minDate: moment(),
                    //     maxDate: moment().add(data.cupo.zonatiemporeservamax, 'days')
                    // })

                },
                error: function(error){
                    console.log(error);
                    $('#reservacupos').val('');
                }
            });
        });

        $("#reservacupos").on('change', function(e) {
            if($( "#fecha" ).val()){
                obtenerHoras();
            }
        });

        $("#unidadid").on('change', function(e) {
            $('#disponibilidad').html('');
            if($( "#fecha" ).val()){
                obtenerHoras();
            }
        });

        // $("#fecha").on('focusout', function(e) {

        //     obtenerHoras();
        // });

        $("#fecha").on('focusout', function(e) {

            var zc = {{$zonareserva->zonacompartida}};
            if(zc == 1) {
                obtenerHoras();
            }else{

                $('#franja option').each(function() {
                    $(this).remove();
                });

                var zonaid = $( "#zonaid" ).val();
                var fecha = $( "#fecha" ).val();

                $.ajax({
                    data: {
                        zonaid: zonaid,
                        fecha: fecha,
                        franjas: {{$zonareserva->zonareservadiariamax}},
                        cierre: '04:00',
                        _token: "{{csrf_token()}}"
                    },
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.reservas.numhoras') }}",
                    success: function(data) {
                        $('#franja option').each(function() {
                            $(this).remove();
                        });

                        var zc = {{$zonareserva->zonacompartida}};
                        if(zc == 0) {
                            for (var i = 1; i <= data.horas; i++) {
                                $('#franja').append('<option value="'+ i +'">'+ i +'</option>');
                            }
                        }

                    },
                    error: function(error){
                        //console.log(error);
                        $('#franja').val('');

                    }
                });
            }

        });

        function obtenerHoras(){
            $('#mensajes').html('');
            $('#disponibilidad').html('');
            if($( "#reservacupos" ).val()){
                var unidadid = $( "#unidadid" ).val();
                var zonaid = $( "#zonaid" ).val();
                var fecha = $( "#fecha" ).val();
                var reservacupos = $( "#reservacupos" ).val();

                $.ajax({
                    data: {
                            unidadid: unidadid,
                            zonaid: zonaid,
                            fecha: fecha,
                            reservacupos: reservacupos,
                            reservadiariamax: {{$zonareserva->zonareservadiariamax}},
                            _token: "{{csrf_token()}}"
                        },
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.reservas.horas') }}",
                    success: function(data) {
                        zonacompartida = {{$zonareserva->zonacompartida}};
                        var cont = Object.keys(data.horas).length;
                        var arr = "";
                        if(cont){
                            $.each(data, function(i, res){
                                $.each(res, function(index, res1){
                                    var color = ""; var btn_reserva = "";
                                    var franja_reserva =  moment(res1.start, 'YYYY-MM-DD HH:mm').format('h:mm') + " - " + moment(res1.end, 'YYYY-MM-DD HH:mm').format('h:mm a');

                                    if (((res1.zonaaforomax - res1.reservas) >= reservacupos) && (res1.contador < {{$zonareserva->zonareservadiariamax}})){
                                        if (zonacompartida == 1){
                                            btn_reserva = "<a href='#' class='btn_reservar dropdown-item text-success' id='"+res1.id+"'><i class='fas fa-plus'></i> Reservar</a>";
                                        }else{
                                            btn_reserva = "<div class='icheck-primary d-inline'><input type='checkbox' name='franja[]' id='"+res1.id+"' value='"+res1.id+"'><label for='"+res1.id+"'></label></div>";
                                        }
                                    }

                                    if((res1.reservas >= 1) && (res1.reservas < res1.zonaaforomax)){
                                        color = 'danger';

                                    }else if(res1.reservas >= res1.zonaaforomax){
                                        color = 'danger';
                                        if (res1.contador < {{$zonareserva->zonareservadiariamax}}){
                                            btn_reserva = "<span class='mr-4'>&nbsp;&nbsp;</span>";
                                        }
                                    }else{

                                        color = 'secondary';
                                    }
                                    if (zonacompartida == 1){
                                        arr += "<div class='col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2'><div class='form-group input-group-prepend'><button type='button' class='btn btn-outline-"+ color +" dropdown-toggle' data-toggle='dropdown'><small>" + moment(res1.start, 'YYYY-MM-DD HH:mm').format('hh:mm') + " - " + moment(res1.end, 'YYYY-MM-DD HH:mm').format('hh:mm a') +"</small></button><div class='dropdown-menu'><a class='dropdown-item'><i class='fas fa-user-friends'></i>&nbsp; <b>Aforo Maximo: "+ res1.zonaaforomax +"</b></a><div class='dropdown-divider'></div><a class='dropdown-item'><i class='fas fa-caret-right'></i> Plazas disponibles: <b>"+ (res1.zonaaforomax - res1.reservas) +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Cupos reservados: <b>"+ res1.reservas +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Ocupacion: <span class='text-primary'>" + Math.round((1 - ((res1.zonaaforomax - res1.reservas)/res1.zonaaforomax))*100) + "%</span></a><div class='dropdown-divider'></div>" + btn_reserva + "</div></div></div>";
                                    }else{
                                        arr += "<div class='col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2'><div class='form-group input-group-prepend'>"+ btn_reserva +"<button type='button' class='btn btn-outline-"+ color +" dropdown-toggle' data-toggle='dropdown'><small>" + moment(res1.start, 'YYYY-MM-DD HH:mm').format('hh:mm') + " - " + moment(res1.end, 'YYYY-MM-DD HH:mm').format('hh:mm a') +"</small></button><div class='dropdown-menu'><a class='dropdown-item'><i class='fas fa-user-friends'></i>&nbsp; <b>Aforo Maximo: "+ res1.zonaaforomax +"</b></a><div class='dropdown-divider'></div><a class='dropdown-item'><i class='fas fa-caret-right'></i> Plazas disponibles: <b>"+ (res1.zonaaforomax - res1.reservas) +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Cupos reservados: <b>"+ res1.reservas +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Ocupacion: <span class='text-primary'>" + Math.round((1 - ((res1.zonaaforomax - res1.reservas)/res1.zonaaforomax))*100) + "%</span></a></div></div></div>";
                                    }
                                    if (res1.contador > {{$zonareserva->zonareservadiariamax}}){
                                        arr = "<div class='col-12'><div class='alert alert-default-warning alert-dismissible fade show' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Ha superado el numero máximo de reservas diarias.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div></div>";
                                    }

                                })
                            })
                        }else{
                            arr = "<div class='col-12'><div class='alert alert-default-warning' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada.</div></div>";
                        }

                        $('#disponibilidad').html(arr);

                        $(".btn_reservar").on('click', function(){
                            $.ajax({
                                data: {
                                    calendarid: $(this).attr('id'),
                                    zonaid: zonaid,
                                    unidadid: $('#unidadid').val(),
                                    reservacupos: reservacupos,
                                    precio: {{$zonareserva->zonaprecio}},
                                    _token: "{{csrf_token()}}"
                                },
                                type: "POST",
                                dataType: "json",
                                url: "{{ route('admin.reservas.store') }}",
                                success: function(data) {
                                    zonacompartida = {{$zonareserva->zonacompartida}};
                                    //obtenerHoras();
                                    toastr.success("La reserva se realizó de forma exitosa.");
                                    if (zonacompartida == 1){
                                        arr = "<div class='col-12'><div class='alert alert-default-success alert-dismissible fade show' role='alert'><i class='fas fa-check'></i>&nbsp; La reserva se realizó de forma exitosa. Para ver todas las reservas pendientes haga click en <a class='text-primary' href='/admin/reservas'>Reservas</a><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div></div>";
                                        $('#disponibilidad').html(arr);
                                    }else{
                                        obtenerHoras();
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                    toastr.error("Hubo un error al realizar la reserva, por favor intente nuevamente.")

                                }
                            });

                        })
                    },
                    error: function(error){
                        console.log(error);

                    }
                });
            }else{
                alert('seleccione el cupo');
            }
        }

    })


</script>
@stop









