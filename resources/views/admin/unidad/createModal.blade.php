@extends('layouts/plantilla')

@section('content')

<div class="card card-primary">

    {{-- <div class="card-header bg-primary">
        <h1 class="card-title">Asignar propietario</h1>
    </div> --}}
    <!-- /.card-header -->
    <div class="card-body">
        {!! Form::hidden('unidad_propietario', 1) !!}
        {!! Form::hidden('residentes', 1) !!}
        {!! Form::hidden('rol', 5) !!}
        {!! Form::hidden('tiporesidenteid', 1, array('class' => 'tiporesidenteid')) !!}
        {!! Form::hidden('relationid', 1) !!}
        <div class="row">
            <div class="col-12 col-md-8">
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
                        {!! Form::text('personadocumento', null, array('placeholder' => 'Ingrese el No. de documento', 'class' => 'form-control', 'required')) !!}
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
                    {!! Form::text('personanombre', null, array('placeholder' => 'Ej: Jose Perez Marquez', 'class' => 'form-control', 'required')) !!}
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
                        {{ Form::email('personacorreo', null, array('placeholder' => 'Ej: pedro@gmail.com', 'class' => 'form-control', 'required')) }}
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

            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('reside', 1, true, ['class'=>'mr-1']) !!}
                        Reside en la Unidad
                    </label>
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

        $('input[type=checkbox]').on('change', function() {
            if ($(this).is(':checked') ) {
                $('.tiporesidenteid').val('1')
            } else {
                $('.tiporesidenteid').val(null)
            }
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
                }
            });
            $('#personanombre').focus();
        }else{
            $('#tipodocumentoid').val(1).change();
            $('#personanombre').val('');
            $('#personafechanacimiento').val('');
            $('#personacelular').val('');
            $('#personacorreo').val('');
            $('#personadocumento').focus();
        }
      })

    })
</script>
@stop
