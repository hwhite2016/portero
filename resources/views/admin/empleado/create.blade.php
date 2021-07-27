@extends('adminlte::page')

@section('title', 'Empleados')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Timepicker', 'true')

@section('content_header')

@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.empleados.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO EMPLEADO</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-4">
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
                    {{ Form::label('tipodocumentoid', '* Tipo Documento') }}
                    {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo de documento']) !!}
                </div>
            </div>

            <div class="col-md-4">
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
                <div class="form-group"> <!-- Fecha de Nacimiento -->
                    {{ Form::label('personafechanacimiento', 'Fecha de Nacimiento') }}
                    <div class="input-group date" id="fechanacimiento" data-target-input="nearest">
                        {!! Form::text('personafechanacimiento', null, array('data-toggle' => 'datetimepicker','data-target' => '#fechanacimiento', 'class' => 'form-control datetimepicker-input')) !!}
                        <div class="input-group-append" data-target="#fechanacimiento" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                    </div>
                    @error('personafechanacimiento')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Correo -->
                    {{ Form::label('personacorreo', 'Correo') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        {{ Form::email('personacorreo', null, array('placeholder' => 'Ej: pedro@gmail.com', 'class' => 'form-control')) }}
                        @error('personacorreo')
                            <small class="text-danger">
                                {{$message}}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('role_id', 'Rol') }}
                    {!! Form::select('role_id', $roles, null, ['class' => 'form-control  select2', 'style'=>'width: 100%','data-placeholder'=>'Seleccione un rol']) !!}
                    @error('role_id')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Estado -->
                    {{ Form::label('empleadoestado', 'Estado') }}
                    {!! Form::select('empleadoestado', ['0'=>'Inactivo','1'=>'Activo'], null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('empleadoestado')
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
        <a class="btn btn-warning" href="{{route('admin.empleados.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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
      $('.select2').select2();

      $(":input").inputmask();

      $('#fechanacimiento').datetimepicker({
           format: 'L',
           format: 'YYYY/MM/DD'
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
                    $('#personafechanacimiento').val(moment(data.persona.personafechanacimiento).format('YYYY/MM/DD'));
                    $('#personacelular').val(data.persona.personacelular);
                    $('#personacorreo').val(data.persona.personacorreo);
                    $('#tipodocumentoid').val(data.persona.tipodocumentoid).change();

                },
                error: function(error){
                    console.log(error);
                    $('#tipodocumentoid').val(1).change();
                    $('#personanombre').val('');
                    $('#personafechanacimiento').val('');
                    $('#personacelular').val('');
                    $('#personacorreo').val('');
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
            $('#personafechanacimiento').val('');
            $('#personacelular').val('');
            $('#personacorreo').val('');
            // $('#personanombre').prop('disabled', false);
            // $('#personacelular').prop('disabled', false);
            // $('#tipodocumentoid').prop('disabled', false);
            $('#personadocumento').focus();
        }
      })

    })
</script>
@stop
