@extends('adminlte::page_error')

@section('title', 'Registro')

@section('plugins.Select2', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Timepicker', 'true')


@section('content_header')
    <div class='alert alert-default-primary alert-dismissible fade show' role='alert'>
        <i class="fas fa-info-circle"></i>&nbsp;
        Estimado usuario, a continuación encontrara un formulario donde podrá diligenciar los datos de las personas y mascotas que conviven en
        su casa o apartamento con el fin de actualizar el censo de la copropiedad, y que usted en su rol de propietario y/o residente, pueda comenzar a disfrutar
        de los beneficios que le ofrece su conjunto residencial a través de esta plataforma.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
@stop

@section('content')
<div class="card">
    {!! Form::open(['route'=>'registros.store', 'method'=>'post']) !!}
    @csrf
    <div class="card-header bg-light">
        <h1 class="card-title"><i class="far fa-file-alt"></i> <label>Formulario de registro</label></h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group"> <!-- Pais -->
                    {{ Form::label('paisid', '* Pais') }}
                    {!! Form::select('paisid', $pais, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un pais']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Ciudad -->
                    {{ Form::label('ciudadid', '* Ciudad') }}
                    {!! Form::select('ciudadid', $ciudads, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione una ciudad']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Barrio -->
                    {{ Form::label('barrioid', '* Barrio') }}
                    {!! Form::select('barrioid', $barrios, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un barrio']) !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group"> <!-- Conjunto -->
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la copropiedad']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group"> <!-- Bloque -->
                    {{ Form::label('bloqueid', '* Bloque / Torre') }}
                    {!! Form::select('bloqueid', $bloques, old('bloqueid'), ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el bloque']) !!}
                    @error('bloqueid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"> <!-- Unidad -->
                    {{ Form::label('unidadid', '* Unidad') }}
                    {!! Form::select('unidadid', [], old('unidadid'), ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la unidad']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            {{-- <div class="col-md-5">
                <div class="form-group">
                    {{ Form::label('parqueaderoid', 'Parqueaderos asignados') }}
                    {!! Form::select('parqueaderos[]', $parqueaderos, old('parqueaderos[]'), ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Seleccione los parqueaderos asignados', 'data-width'=>'100%']) !!}
                </div>
            </div> --}}

        </div>
        <!-- /.Row -->
        <br>
        <div class="row">


            <!-- TAB -->
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-propietarios-tab" data-toggle="pill" href="#custom-tabs-four-propietarios" role="tab" aria-controls="custom-tabs-four-propietarios" aria-selected="true"><i class="fas fa-user"></i> Titular de la unidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" tabindex="-1" id="custom-tabs-four-residentes-tab" data-toggle="pill" href="#custom-tabs-four-residentes" role="tab" aria-controls="custom-tabs-four-residentes" aria-selected="true"><i class="fas fa-user"></i> Residentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" tabindex="-1" id="custom-tabs-four-vehiculos-tab" data-toggle="pill" href="#custom-tabs-four-vehiculos" role="tab" aria-controls="custom-tabs-four-vehiculos" aria-selected="false"><i class="fas fa-car"></i> Vehiculos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" tabindex="-1" id="custom-tabs-four-mascotas-tab" data-toggle="pill" href="#custom-tabs-four-mascotas" role="tab" aria-controls="custom-tabs-four-mascotas" aria-selected="false"><i class="fas fa-paw"></i> Mascotas</a>
                    </li>
                    </ul>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-propietarios" role="tabpanel" aria-labelledby="custom-tabs-four-propietarios-tab">
                        @include('registro.createPropietario')
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-residentes" role="tabpanel" aria-labelledby="custom-tabs-four-residentes-tab">
                        {{-- @include('admin.residentes.indexModal') --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-vehiculos" role="tabpanel" aria-labelledby="custom-tabs-four-vehiculos-tab">
                        {{-- @include('admin.vehiculo.indexModal') --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-mascotas" role="tabpanel" aria-labelledby="custom-tabs-four-mascotas-tab">
                        {{-- @include('admin.mascota.indexModal') --}}
                    </div>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.TAB -->


        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
    </div>
    <!-- /.card-footer -->
    {!! Form::close() !!}
</div>
  <!-- /.card -->

@stop

@section('css')

@stop

@section('js')

    @if(session('info'))
        <script type="text/javascript">
            toastr.success("{{session('info')}}")
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();

            $(":input").inputmask();

            $('#fechanacimiento').datetimepicker({
                format: 'L',
                format: 'YYYY/MM/DD'
            });

            $("#conjuntoid").on('change', function(e) {
                $('#bloqueid option').each(function() {
                    $(this).remove();
                });
                $('#unidadid option').each(function() {
                    $(this).remove();
                });

                var id = $( "#conjuntoid" ).val();
                var url = "{{ route('registros.bloque', ":id") }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {

                        $('#bloqueid').append('<option value="">Seleccione un bloque</option>');
                        $.each(data, function(i, res){
                            $.each(res, function(index, res1){
                                //console.log(res);
                                $('#bloqueid').append('<option value="'+ res1.id +'">'+ res1.bloquenombre +'</option>');
                            })
                        })
                    },
                    error: function(error){
                        console.log(error);
                        $('#bloqueid').val('');
                    }
                });
            })

            $("#bloqueid").on('change', function(e) {
                $('#unidadid option').each(function() {
                    $(this).remove();
                });

                var id = $( "#bloqueid" ).val();
                var url = "{{ route('registros.unidad', ":id") }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {

                        $('#unidadid').append('<option value="">Seleccione una unidad</option>');
                        $.each(data, function(i, res){
                            $.each(res, function(index, res1){
                                //console.log(res);
                                $('#unidadid').append('<option value="'+ res1.id +'">'+ res1.unidadnombre +'</option>');
                            })
                        })
                    },
                    error: function(error){
                        console.log(error);
                        $('#unidadid').val('');
                    }
                });
            })

            $("#unidadid").on('change', function(e) {

            })


        })

    </script>
@stop
