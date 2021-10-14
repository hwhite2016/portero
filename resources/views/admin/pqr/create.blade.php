@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear pqrs/h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::open(['route'=>'admin.pqrs.store', 'method'=>'post', 'id'=>'pqr', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Crear Nuevo Ticket</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2','style'=>'width: 100%']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('tipopqrid', '* Tipo de Ticket') }}&nbsp;
                    <a href="#" data-placement="bottom"  tabindex="0" data-toggle="popover" data-trigger="focus" data-popover-content="#a2">
                        <i class="far fa-question-circle"></i>
                    </a>
                    {!! Form::select('tipopqrid', $tipo_pqrs, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo de Ticket']) !!}
                    @error('tipopqrid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>

                <!-- Content for Popover -->
                <div id="a2" class="d-none popover">
                    <div class="popover-heading"><i class="far fa-envelope"></i> &nbsp; <b>Tipos de Ticket</b></div>

                    <div class="popover-body">
                        <div class='row'>
                            <div class='col-4 border'><b>Petición</b><br><small>Tiempo de respuesta: 15 dias</small></div>
                            <div class='col-8 border'>En esta opción podrás realizar solicitudes y trámites de procedimientos a la administración, referente a los servicios preestablecidos.</div>
                            <div class='col-4 border'><b>Queja</b><br><small>Tiempo de respuesta: 15 dias</small></div>
                            <div class='col-8 border'>Utiliza esta opción si necesitas comunicar a la administración la conducta de alguno de nuestros colaboradores o si consideras apropiado alertar sobre el incumplimiento de un procedimiento o suspensión de un servicio.</div>
                            <div class='col-4 border'><b>Reclamo</b><br><small>Tiempo de respuesta: 15 dias</small></div>
                            <div class='col-8 border'>Utiliza esta opción para exigir o demandar una solución, ya sea por motivo general o particular, referente a la prestación indebida de un servicio o a la falta de atención de una solicitud.</div>
                            <div class='col-4 border'><b>Sugerencia</b><br><small>Tiempo de respuesta: 15 dias</small></div>
                            <div class='col-8 border'>Utiliza esta opción si deseas aportar ideas o iniciativas para mejorar la calidad del conjunto.</div>
                            <div class='col-4 border'><b>Felicitación</b><br><small>Tiempo de respuesta: 15 dias</small></div>
                            <div class='col-8 border'>Utiliza esta opción si deseas expresar tu satisfacción frente a un colaborador, un procedimiento o un servicio del conjunto.</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Asunto -->
                    {{ Form::label('asuntoid', '* Asunto') }}
                    {!! Form::select('asuntoid', $asuntos, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el asunto']) !!}
                    @error('asuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group"> <!-- Asignado a -->
                    {{ Form::label('organo_id', '* Asignado a') }}
                    {!! Form::select('organo_id', $organos, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
                    @error('organo_id')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group"> <!-- Destinatarios -->
                    {{ Form::label('organos', 'Copiar a') }}
                    {{-- {!! Form::select('organo_id', $colaboradores, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'']) !!} --}}
                    {!! Form::select('organos[]', $organos, old('organos[]'), ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione los destinatarios', 'data-width'=>'100%']) !!}
                    {{-- <br>{!! Form::checkbox('consejo', 1, true, ['class'=>'mr-1 consejo']) !!}<small class="font-italic">Copiar al Consejo de Administración</small> --}}
                    @error('organos')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Detalle del caso -->
                    {{ Form::label('mensaje', '* A continuación detalle su caso') }} <small class="font-italic"> (Max. 3.000 caractéres)</small>
                    {!! Form::textarea('mensaje', null, ['spellcheck' => true, 'class' => 'form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('mensaje')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>



            <div class="col-12">
                <div class="form-group"> <!-- Evidencia -->
                    {{ Form::label('adjunto', 'Adjuntar Evidencia') }} <small class="font-italic"> (Opcional)</small><br>
                    {{ Form::file('adjunto', array('accept' => 'application/pdf,image/jpg,image/jpeg,image/png,image/svg')) }}
                    <br>
                    @error('adjunto')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                    <br>
                    <small class="p-1">Max. 2MB</small> <small class="font-italic"> (Solo imagenes y archivos pdf)</small>

                </div>
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.pqrs.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Enviar', ['class'=>'btn btn-primary', 'id'=>'guardarPqr']) !!}
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
    <style>
        @media (min-width: 320px) {
            .popover {
                max-width: 90%;
                justify-content: flex-start;
            }
        }

        @media (min-width: 992px) {
            .popover {
                max-width: 600px;
                justify-content: flex-start;
            }
        }

    </style>

 @stop

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


<script>
    $(function () {
      //Initialize Select2 Elements
        $('.select2').select2();

        $('#guardarPqr').on('click', function() {
            $(this).prop('disabled',true);
            $(this).val('Enviando..');
            $('#pqr').submit();
        });

        $("[data-toggle=popover]").popover({
            html : true,
            container: 'body',
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
                },
                title: function() {
                var title = $(this).attr("data-popover-content");
                return $(title).children(".popover-heading").html();
            }
        });
    })

</script>
@stop
