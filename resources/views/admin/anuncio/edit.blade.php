@extends('adminlte::page')

@section('title', 'Comunicados')

@section('plugins.Toastr', 'true')
@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear Unidad</h1> --}}
@stop

@section('content')
<br>
<div class="card">
    {!! Form::model($anuncio, ['route'=>['admin.anuncios.update', $anuncio], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Crear Nuevo Comunicado</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group"> <!-- Tipo anuncio -->
                    {{ Form::label('tipoanuncioid', '* Tipo de Comunicado') }}
                    {!! Form::select('tipoanuncioid', $tipo_anuncio, null, ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
                    @error('tipoanuncioid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
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

            <div class="col-md-2">
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
            <div class="col-md-3">
                <div class="form-group"> <!-- Unidad -->
                    {{ Form::label('unidadid', '* Unidad') }}
                    {!! Form::select('unidadid[]', $unidades, true, ['id'=>'unidadid','class' => 'form-control  select2','multiple'=>'multiple', 'style'=>'width: 100%','data-placeholder'=>'Seleccione la unidad']) !!}
                    @error('unidadid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Titulo anuncio -->
                    {{ Form::label('anuncionombre', '* Titulo del Comunicado') }}
                    {{ Form::text('anuncionombre', old('anuncionombre'), array('class' => 'form-control')) }}
                    @error('anuncionombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Adjunto -->
                    {{ Form::label('anuncioadjunto', 'Adjuntar archivo') }}
                    <small class="font-italic"> (Opcional - Solo imagenes y archivos pdf)</small>
                    <small class="p-1">Max. 2MB</small>
                    <br>
                    {{ Form::file('anuncioadjunto', array('accept' => 'application/pdf,image/jpg,image/jpeg,image/png,image/svg')) }}
                    <br>
                    @if($anuncio->anuncioadjunto)
                    <a class="text-primary" href="{{route('admin.anuncios.delFile', $anuncio->id)}}">
                        <i class="far fa-trash-alt"></i>
                    </a>
                    <a target="_blank" class="text-primary" href="/storage/{{$anuncio->conjuntoid}}/comunicados/{{$anuncio->anuncioadjunto}}">
                        <u>Ver archivo</u>
                    </a>
                    <br>
                    @endif
                    @error('anuncioadjunto')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Contenido -->
                    {{ Form::label('anunciodescripcion', 'Contenido del Comunicado') }} <small class="font-italic"> (Max. 1.500 caractéres)</small>
                    {!! Form::textarea('anunciodescripcion', null, ['spellcheck' => true, 'class' => 'textarea form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('anunciodescripcion')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

        </div>
        <!-- /.row-->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.anuncios.index')}}"><i class="fas fa-angle-double-left"></i> Volver</a>
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

@if(session('info'))
    <script type="text/javascript">
        var txt = "{{session('info')}}";
        var msj = txt.toLowerCase().indexOf('error')
        if (msj >= 0){
            toastr.error("{{session('info')}}")
        }else{
            toastr.success("{{session('info')}}")
        }
    </script>
@endif

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        $("#conjuntoid").on('change', function(e) {
            $('#bloqueid option').each(function() {
                $(this).remove();
            });
            $('#unidadid[] option').each(function() {
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
