@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.zonas.store', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVA ZONA COMUN</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group"> <!-- Conjunto -->
                    {!! Form::label('conjuntoid', 'Conjunto') !!}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group"> <!-- Nombre de la Zona -->
                    {!! Form::label('zonanombre', 'Nombre de la zona') !!}
                    {!! Form::text('zonanombre', null, array('placeholder' => 'Ej: Piscina de niños, Gimnasio, ...', 'class' => 'form-control')) !!}
                    @error('zonanombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Reservable -->
                    {!! Form::label('zonareservable', 'Reservable') !!}
                    {!! Form::select('zonareservable', ['0'=>'NO', '1'=>'SI'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('zonareservable')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Imagen de la zona -->
                    {{ Form::label('zonaimagen', 'Imagen de la zona') }}
                    {{ Form::file('zonaimagen', array('accept' => 'image/jpg,image/jpeg,image/png,image/svg', 'class' => 'form-control')) }}
                    @error('zonaimagen')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Hora de apertura-->
                    {!! Form::label('zonahoraapertura', 'Hora de apertura') !!}
                    {!! Form::time('zonahoraapertura', null, array('class' => 'form-control')) !!}
                    @error('zonahoraapertura')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Hora de cierre-->
                    {!! Form::label('zonahoracierre', 'Hora de cierre') !!}
                    {!! Form::time('zonahoracierre', null, array('class' => 'form-control')) !!}
                    @error('zonahoracierre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Aforo maximo -->
                    {!! Form::label('zonaaforomax', 'Aforo máximo') !!}
                    {!! Form::number('zonaaforomax', null, array('placeholder' => '', 'class' => 'form-control')) !!}
                    @error('zonaaforomax')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Valor de la reserva (precio) -->
                    {!! Form::label('zonaprecio', 'Valor de la reserva') !!}
                    {!! Form::number('zonaprecio', null, array('placeholder' => '0', 'class' => 'form-control')) !!}
                    @error('zonaprecio')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Franja -->
                    {!! Form::label('zonafranjatiempo', 'Franjas de reserva') !!}
                    {!! Form::select('zonafranjatiempo', ['00:30:00'=>'30 Minutos', '01:00:00'=>'1 Hora','01:30:00'=>'1 Hora y media', '02:00:00'=>'2 Horas','02:30:00'=>'2 Horas y media', '03:00:00'=>'3 Horas','03:30:00'=>'3 Horas y media', '04:00:00'=>'4 Horas'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('zonafranjatiempo')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group"> <!-- Morosos -->
                    {!! Form::label('zonamorosos', 'Los morosos pueden reservar') !!}
                    {!! Form::select('zonamorosos', ['0'=>'NO', '1'=>'SI'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('zonamorosos')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Cupo maximo de personas por reserva -->
                    {!! Form::label('zonacuporeservamax', 'Cupo maximo de personas por reserva') !!}
                    {!! Form::number('zonacuporeservamax', null, array('placeholder' => '', 'class' => 'form-control')) !!}
                    @error('zonacuporeservamax')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Tiempo de antelacion para reservar -->
                    {!! Form::label('zonatiemporeservamax', 'Tiempo de antelacion para reservar') !!}
                    {!! Form::select('zonatiemporeservamax', ['1'=>'1 Día', '2'=>'2 Días','3'=>'3 Días', '4'=>'4 Días','5'=>'5 Días','6'=>'6 Días','7'=>'7 Días'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('zonatiemporeservamax')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Numero max. de reservas el mismo dia por unidad -->
                    {!! Form::label('zonareservadiariamax', 'Numero max. de reservas el mismo dia por unidad') !!}
                    {!! Form::number('zonareservadiariamax', null, array('placeholder' => '', 'class' => 'form-control')) !!}
                    @error('zonareservadiariamax')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Descripcion de la Zona -->
                    {!! Form::label('zonadescripcion', 'Descripcion de la zona') !!} <small class="text-primary"> (Max.: 300 caracteres)</small>
                    {!! Form::textarea('zonadescripcion', null, ['class' => 'form-control' , 'rows' => 3, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('zonadescripcion')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Terminos y condiciones de uso -->
                    {!! Form::label('zonaterminos', 'Terminos y condiciones de uso') !!} <small class="text-primary"> (Max.: 1.800 caracteres)</small>
                    {!! Form::textarea('zonaterminos', null, ['class' => 'form-control' , 'rows' => 3, 'cols' => 20, 'style' => 'resize:true']) !!}
                    @error('zonaterminos')
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
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        // $('#datetimepicker3, #datetimepicker2').datetimepicker({
        //     format: 'LT'
        // });


            // jQuery('#init-date, #end-date').datetimepicker({
            //     format: 'H:mm'
            // });

            // jQuery('#zonahoraapertura, #zonahoracierre').on('focusout', () => {
            //     const initDateValue = moment(jQuery('#zonahoraapertura').data('date'), 'H:mm');
            //     const endDateValue = moment(jQuery('#zonahoracierre').data('date'), 'H:mm');

            //     if(!initDateValue.isValid() || !endDateValue.isValid()) return;

            //     if(endDateValue.isBefore(initDateValue)) {
            //         jQuery('#zonahoraapertura').val(jQuery('#zonahoracierre').val());
            //     }
            // });

    })
</script>
@stop









