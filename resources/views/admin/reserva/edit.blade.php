@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')
<br>
<div class="card card-primary card-outline">

    <div class="card-header">
        {{-- <h1 class="card-title text-primary">
            <label>Nueva Reserva</label>
        </h1> --}}
        @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="fas fa-swimmer"></i> &nbsp Mis reservas</a>
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
        <div class="row" id="disponibilidad">

            {{-- <div class="col-md-3">
                <div class="form-group input-group-prepend">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                        10:00 am
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"><b>Plazas disponibles: 6</b></a>
                         <a class="dropdown-item"><i class="fas fa-caret-right"></i> Ocupacion al <span class="text-success">34%</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-success" href="#"><i class="fas fa-plus"></i> Reservar</a>
                    </div>
                </div>
            </div> --}}

        </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {{-- <a class="btn btn-warning" href="{{route('admin.reservas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a> --}}
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

        for (var i = 1; i <= {{$zonareserva->zonacuporeservamax}}; i++) {
            $('#reservacupos').append('<option value="'+ i +'">'+ i +'</option>');
        }
        $('#fecha2').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment(),
            maxDate: moment().add({{$zonareserva->zonatiemporeservamax}}, 'days')
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
                    console.log(data.cupo.zonatiemporeservamax);
                    $("#reservacupos").empty();
                    //$('#reservacupos').append('<option value="">seleccione el cupo</option>');
                    for (var i = 1; i <= data.cupo.zonacuporeservamax; i++) {
                        $('#reservacupos').append('<option value="'+ i +'">'+ i +'</option>');
                    }

                    $('#fecha2').datetimepicker('destroy');
                    $('#fecha2').datetimepicker({
                        format: 'YYYY-MM-DD',
                        minDate: moment(),
                        maxDate: moment().add(data.cupo.zonatiemporeservamax, 'days')
                    })

                },
                error: function(error){
                    console.log(error);
                    $('#reservacupos').val('');
                }
            });
        });

        $("#reservacupos").on('change', function(e) {
            $('#disponibilidad').html('');
            //$('#fecha').val('');
            if($( "#fecha" ).val()){
                var zonaid = $( "#zonaid" ).val();
                var fecha = $( "#fecha" ).val();
                var reservacupos = $( "#reservacupos" ).val();

                $.ajax({
                    data: {
                            zonaid: zonaid,
                            fecha: fecha,
                            reservacupos: reservacupos,
                            _token: "{{csrf_token()}}"
                        },
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.reservas.horas') }}",
                    success: function(data) {
                        var cont = Object.keys(data.horas).length;
                        var arr = ""; var color = ""; var btn_reserva = "";
                        if(cont){
                            $.each(data, function(i, res){
                                $.each(res, function(index, res1){
                                    console.log(res1);
                                    if((res1.reservas >= 1) && (res1.reservas < res1.zonaaforomax)){
                                        color = 'warning';
                                        btn_reserva = "<a class='dropdown-item text-success' href='#'><i class='fas fa-plus'></i> Reservar</a>";
                                    }else if(res1.reservas >= res1.zonaaforomax){
                                        color = 'danger';
                                        btn_reserva = "";
                                    }else{
                                        color = 'success';
                                        btn_reserva = "<a class='dropdown-item text-success' href='#'><i class='fas fa-plus'></i> Reservar</a>";
                                    }
                                    arr += "<div class='col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2'><div class='form-group input-group-prepend'><button type='button' class='btn btn-"+ color +" dropdown-toggle' data-toggle='dropdown'>" + moment(res1.hora, 'HH:mm').format('hh:mm a') + "</button><div class='dropdown-menu'><a class='dropdown-item'><i class='fas fa-user-friends'></i>&nbsp; <b>Aforo Maximo: "+ res1.zonaaforomax +"</b></a><div class='dropdown-divider'></div><a class='dropdown-item'><i class='fas fa-caret-right'></i> Plazas disponibles: <b>"+ (res1.zonaaforomax - res1.reservas) +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Cupos reservados: <b>"+ res1.reservas +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Ocupacion: <span class='text-primary'>" + Math.round((1 - ((res1.zonaaforomax - res1.reservas)/res1.zonaaforomax))*100) + "%</span></a><div class='dropdown-divider'></div>" + btn_reserva + "</div></div></div>";
                                    //arr += res1.hora;
                                })
                            })
                        }else{
                          arr = "<div class='alert alert-default-warning' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada.</div>";
                        }
                        $('#disponibilidad').html(arr);
                    },
                    error: function(error){
                        console.log(error);

                    }
                });
            }
        });

        $("#fecha").on('focusout', function(e) {
            $('#disponibilidad').html('');
            if($( "#reservacupos" ).val()){
                var zonaid = $( "#zonaid" ).val();
                var fecha = $( "#fecha" ).val();
                var reservacupos = $( "#reservacupos" ).val();

                $.ajax({
                    data: {
                            zonaid: zonaid,
                            fecha: fecha,
                            reservacupos: reservacupos,
                            _token: "{{csrf_token()}}"
                        },
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.reservas.horas') }}",
                    success: function(data) {
                        var cont = Object.keys(data.horas).length;
                        var arr = ""; var color = ""; var btn_reserva = "";
                        if(cont){
                            $.each(data, function(i, res){
                                $.each(res, function(index, res1){
                                    console.log(res1);
                                    if((res1.reservas >= 1) && (res1.reservas < res1.zonaaforomax)){
                                        color = 'warning';
                                        btn_reserva = "<a class='dropdown-item text-success' href='#'><i class='fas fa-plus'></i> Reservar</a>";
                                    }else if(res1.reservas >= res1.zonaaforomax){
                                        color = 'danger';
                                        btn_reserva = "";
                                    }else{
                                        color = 'success';
                                        btn_reserva = "<a class='dropdown-item text-success' href='#'><i class='fas fa-plus'></i> Reservar</a>";
                                    }
                                    arr += "<div class='col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2'><div class='form-group input-group-prepend'><button type='button' class='btn btn-"+ color +" dropdown-toggle' data-toggle='dropdown'>" + moment(res1.hora, 'HH:mm').format('hh:mm a') + "</button><div class='dropdown-menu'><a class='dropdown-item'><i class='fas fa-user-friends'></i>&nbsp; <b>Aforo Maximo: "+ res1.zonaaforomax +"</b></a><div class='dropdown-divider'></div><a class='dropdown-item'><i class='fas fa-caret-right'></i> Plazas disponibles: <b>"+ (res1.zonaaforomax - res1.reservas) +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Cupos reservados: <b>"+ res1.reservas +"</b></a><a class='dropdown-item'><i class='fas fa-caret-right'></i> Ocupacion: <span class='text-primary'>" + Math.round((1 - ((res1.zonaaforomax - res1.reservas)/res1.zonaaforomax))*100) + "%</span></a><div class='dropdown-divider'></div>" + btn_reserva + "</div></div></div>";
                                    //arr += res1.hora;
                                })
                            })
                        }else{
                          arr = "<div class='alert alert-default-warning' role='alert'><i class='fas fa-exclamation-triangle'></i>&nbsp; Lo sentimos, no hay disponibilidad de horarios en la fecha seleccionada.</div>";
                        }
                        $('#disponibilidad').html(arr);
                    },
                    error: function(error){
                        console.log(error);

                    }
                });
            }else{
                alert('seleccione el cupo');
            }
        });



    })
</script>
@stop









