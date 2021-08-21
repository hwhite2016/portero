@extends('adminlte::page')

@section('title', 'Horario')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.zonaHorario.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">HORARIO DE SERVICIO - ZONA COMUN</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <div class="row">
            <div class="col-md-4">
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

            <div class="col-md-2">
                <div class="form-group"> <!-- Hora-->
                    {!! Form::label('horaapertura', 'Hora apertura') !!}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        {{-- <input type="text" class="form-control float-right" id="reservationtime"> --}}
                        {!! Form::time('horaapertura', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group"> <!-- Hora-->
                    {!! Form::label('horacierre', 'Hora cierre') !!}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        {{-- <input type="text" class="form-control float-right" id="reservationtime"> --}}
                        {!! Form::time('horacierre', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group"> <!-- Hora-->
                    {!! Form::label('agregar', '&nbsp;') !!}
                    <button type="submit" class="btn btn-primary form-control"><i class="fas fa-plus-circle"></i> &nbsp; Agregar horario</button>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Lunes</span>
                    </div>
                    <div class="card-body">
                        @foreach($lunes as $lun)
                            <div>
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$lun->horaapertura}} - {{$lun->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Martes</span>
                    </div>
                    <div class="card-body">
                        @foreach($martes as $mar)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$mar->horaapertura}} - {{$mar->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Miercoles</span>
                    </div>
                    <div class="card-body">
                        @foreach($miercoles as $mie)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$mie->horaapertura}} - {{$mie->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Jueves</span>
                    </div>
                    <div class="card-body">
                        @foreach($jueves as $jue)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$jue->horaapertura}} - {{$jue->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Viernes</span>
                    </div>
                    <div class="card-body">
                        @foreach($viernes as $vie)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$vie->horaapertura}} - {{$vie->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Sabado</span>
                    </div>
                    <div class="card-body">
                        @foreach($sabado as $sab)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$sab->horaapertura}} - {{$sab->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="font-weight-bold">Domingo</span>
                    </div>
                    <div class="card-body">
                        @foreach($domingo as $dom)
                            <div class="col-md-12 border btn">
                                <a class="text-danger" href=""><i class="fas fa-minus-circle"></i></a> {{$dom->horaapertura}} - {{$dom->horacierre}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div> --}}


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.zonas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
    <!-- daterange picker -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.css">
@stop

@section('js')
<script src="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        $('#fecha2').datetimepicker({
            format: 'L',
            format: 'YYYY/MM/DD'
        });

        // $('#reservationtime').daterangepicker({
        //     minDate:new Date(),
        //     maxDate:moment().add(6, 'days'),
        //     timePicker: true,
        //     timePickerIncrement: 30,
        //     startDate: moment(),
        //     endDate  : moment().add(6, 'days'),
        //     locale: {
        //         format: 'YYYY/MM/DD hh:mm A'
        //     }
        // })

    })
</script>
@stop









