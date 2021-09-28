@extends('adminlte::page')

@section('title', 'Visitantes')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Visitante</h1> --}}
@stop

@section('content')
<br>
<div class="card card-primary">
    {!! Form::model($visitante, ['route'=>['admin.visitantes.update', $visitante], 'method'=>'put']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Editar Visitante</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', 'Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    {{ Form::label('unidadid', 'Unidad') }}
                    {!! Form::select('unidadid', $unidads, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la vivienda']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            @can('admin.seguimiento.index')
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Fecha de ingreso programado -->
                    {{ Form::label('visitanteingreso', 'Fecha y Hora de ingreso') }}
                    <div class="input-group date" id="ingreso" data-target-input="nearest">
                        {!! Form::text('visitanteingreso', null, array('data-toggle' => 'datetimepicker','data-target' => '#ingreso', 'class' => 'form-control datetimepicker-input')) !!}
                        <div class="input-group-append" data-target="#ingreso" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                    </div>
                    @error('visitanteingreso')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            @endcan

            <div class="col-12 col-md-8">
                <div class="form-group"> <!-- Documento ID -->
                    {{ Form::label('personadocumento', '* Documento ID') }}
                    <div class="input-group">
                        {!! Form::text('personadocumento', null, array('placeholder' => 'Ingrese el No. de documento', 'class' => 'form-control')) !!}
                        <div class="input-group-prepend">
                            <a href="#" id="getDocumento" class="input-group-text"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                    @error('personadocumento')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Tipo Documento -->
                    {{ Form::label('tipodocumentoid', 'Tipo Documento') }}
                    {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo de documento']) !!}
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Nombres -->
                    {{ Form::label('personanombre', '* Nombres y Apellidos') }}
                    {!! Form::text('personanombre', null, array('placeholder' => 'Ej: Jose Perez Marquez', 'class' => 'form-control')) !!}
                    @error('personanombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Numero celular -->
                    {{ Form::label('personacelular', 'Numero Celular') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        {{ Form::text('personacelular', null, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}
                        @error('personacelular')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Acompañantes -->
                    {!! Form::label('visitantenumero', 'Nro. de personas que ingresan') !!}
                    {!! Form::number('visitantenumero', 1, ['class' => 'form-control','data-placeholder'=>'Nro. de personas que ingresan']) !!}
                </div>
            </div>

            <div class="col-8">
                <div class="form-group"> <!-- Parqueadero -->
                    {{ Form::label('parqueaderoid', 'Asignar parqueadero') }}
                    {!! Form::select('parqueaderoid', $parqueaderos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un parqueadero disponible']) !!}
                    @error('parqueaderoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group"> <!-- Placa Vehiculo -->
                    {{ Form::label('visitanteplaca', 'Placa del vehiculo') }}
                    {!! Form::text('visitanteplaca', null, array('placeholder' => 'Ej: XYZ-999', 'class' => 'form-control', 'data-inputmask'=>'"mask": "AAA-999"')) !!}
                    @error('visitanteplaca')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Observacion -->
                    {{ Form::label('visitanteobservacion', 'Observaciones') }}
                    {!! Form::textarea('visitanteobservacion', null, ['class' => 'form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('visitanteobservacion')
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
        <a class="btn btn-warning" href="{{route('admin.visitantes.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarUnidad']) !!}
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

      $(":input").inputmask();

      $('#ingreso').datetimepicker({
        icons: {time: "fa fa-clock"},
        format: 'YYYY-MM-DD H:mm:ss'
      });

      $(".fa-search").on('click', function() {
          $('#personanombre').focus();
      });

      $("#personadocumento").on('focusout keypress', function(e) {
        if(e.which == 13) e.preventDefault();
        if ($( "#personadocumento").val()){
            var id = $( "#personadocumento" ).val();
            var url = "{{ route('admin.visitantes.documento', ":id") }}";
            url = url.replace(':id', id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    console.log(data);
                    //var json = $.parseJSON(data);
                    // $('#personanombre').prop('disabled', true);
                    // $('#personacelular').prop('disabled', true);
                    // $('#tipodocumentoid').prop('disabled', true);
                    $('#personanombre').val(data.persona.personanombre);
                    $('#personacelular').val(data.persona.personacelular);
                    $('#tipodocumentoid').val(data.persona.tipodocumentoid).change();

                },
                error: function(error){
                    console.log(error);
                    $('#tipodocumentoid').val(1).change();
                    $('#personanombre').val('');
                    $('#personacelular').val('');
                    // $('#personanombre').prop('disabled', false);
                    // $('#personacelular').prop('disabled', false);
                    // $('#tipodocumentoid').prop('disabled', false);
                    //$('#personanombre').focus();
                }
            });
            $('#personanombre').focus();
        }else{
            $('#tipodocumentoid').val(1).change();
            $('#personanombre').val('');
            $('#personacelular').val('');
            // $('#personanombre').prop('disabled', false);
            // $('#personacelular').prop('disabled', false);
            // $('#tipodocumentoid').prop('disabled', false);
            $('#personadocumento').focus();
        }
      })

    })
</script>
@stop
