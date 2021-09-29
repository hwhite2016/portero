@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')
@section('plugins.Toastr', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')
<br>
<div class="card">

    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Nueva Reserva</label>
        </h1>
        @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="far fa-calendar-check"></i> &nbsp Reservas</a>
        @endcan
        <a class="btn btn-warning float-right mr-2" href="{{route('admin.zonas.index')}}"><i class="fas fa-angle-double-left"></i></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">

            <div class="col-12 col-md-3">
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

            <div class="col-12 col-md-4">
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

            <div class="col-4 col-md-2">
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

            <div class="col-8 col-md-3">
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

        </div>
        <!-- /.row -->
        <p></p>
        <div class="col-md-10">
            <div class="row" id="disponibilidad"></div>


        </div>
    </div>
    <!-- /.card-body -->

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

        $("#fecha").on('focusout', function(e) {
            obtenerHoras();
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
                        var cont = Object.keys(data.horas).length;
                        var arr = "";
                        if(cont){
                            $.each(data, function(i, res){
                                $.each(res, function(index, res1){
                                    var color = ""; var btn_reserva = "";

                                    if (((res1.zonaaforomax - res1.reservas) >= reservacupos) && (res1.contador < {{$zonareserva->zonareservadiariamax}})){
                                        btn_reserva = "<a href='#' class='btn_reservar dropdown-item text-success' id='"+res1.id+"'><i class='fas fa-plus'></i> Reservar</a>";
                                    }

                                    if((res1.reservas >= 1) && (res1.reservas < res1.zonaaforomax)){
                                        color = 'danger';
                                    }else if(res1.reservas >= res1.zonaaforomax){
                                        color = 'danger';
                                        btn_reserva = "";
                                    }else{
                                        color = 'secondary';
                                    }
                                    arr += "<div class='col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2'><div class='form-group input-group-prepend'><button type='button' class='btn btn-block btn-outline-"+ color +" dropdown-toggle' data-toggle='dropdown'><small>" + moment(res1.start, 'YYYY-MM-DD HH:mm').format('h:mm') + " - " + moment(res1.end, 'YYYY-MM-DD HH:mm').format('h:mm a') +"</small></button><div class='dropdown-menu'><a class='dropdown-item'><i class='fas fa-user-friends'></i>&nbsp; <b>Aforo Maximo: "+ res1.zonaaforomax +"</b></a><div class='dropdown-divider'></div><a class='dropdown-item'><i class='fas fa-caret-right'></i> Plazas disponibles: <b>"+ (res1.zonaaforomax - res1.reservas) +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Cupos reservados: <b>"+ res1.reservas +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Ocupacion: <span class='text-primary'>" + Math.round((1 - ((res1.zonaaforomax - res1.reservas)/res1.zonaaforomax))*100) + "%</span></a><div class='dropdown-divider'></div>" + btn_reserva + "</div></div></div>";

                                    if (res1.contador >= {{$zonareserva->zonareservadiariamax}}){
                                        arr = "<div class='col-12'><div class='alert alert-default-warning alert-dismissible fade show' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Ha superado el numero máximo de reservas diarias.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div></div>";
                                    }

                                })
                            })
                        }else{
                          arr = "<div class='col-12'><div class='alert alert-default-warning alert-dismissible fade show' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div></div>";
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









