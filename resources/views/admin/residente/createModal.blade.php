@extends('layouts/plantilla')

@section('content')

<div class="card card-primary">

    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO RESIDENTE</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-8">
                {!! Form::hidden('residentes', 1) !!}
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la copropiedad']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="form-group">
                    {{ Form::label('unidadid', '* Unidad') }}
                    {!! Form::select('unidadid', $unidads, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la vivienda']) !!}
                    @error('unidadid')
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

            {{-- <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Fecha de Nacimiento -->
                    {{ Form::label('personafechanacimiento', 'Fecha de Nacimiento') }}

                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    {!! Form::text('personafechanacimiento', null, array('data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'yyyy/mm/dd', 'data-mask', 'class' => 'form-control')) !!}
                    </div>
                    @error('personafechanacimiento')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div> --}}

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
                    {{ Form::label('rol', 'Rol') }}
                    {!! Form::select('rol', ['5'=>'Residente'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un rol']) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('tiporesidenteid', 'Tipo de residente') }}
                    {!! Form::select('tiporesidenteid', $tipo_residentes, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tiporesidenteid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Relacion -->
                    {{ Form::label('relationid', 'Relacion con el titular') }}
                    {!! Form::select('relationid', $relations, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('relationid')
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
</div>
<!-- /.card -->
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
