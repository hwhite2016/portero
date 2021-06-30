@extends('adminlte::page')

@section('title', 'Horario')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.zonas.store', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
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

            <div class="col-md-2">
                <div class="form-group"> <!-- Conjunto -->
                    {!! Form::label('dia', 'Dia de la Semana') !!}
                    {!! Form::checkbox('dia[]', 0, false, ['class'=>'form-control mr-1']) !!} Lunes
                    @error('dia')
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


            jQuery('#init-date, #end-date').datetimepicker({
                format: 'H:mm'
            });

            jQuery('#init-date, #end-date').on('focusout.datetimepicker', () => {
                const initDateValue = moment(jQuery('#init-date').data('date'), 'H:mm');
                const endDateValue = moment(jQuery('#end-date').data('date'), 'H:mm');

                if(!initDateValue.isValid() || !endDateValue.isValid()) return;

                if(endDateValue.isBefore(initDateValue)) {
                    jQuery('#i').val(jQuery('#e').val());
                }
            });

    })
</script>
@stop









