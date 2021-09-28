@extends('adminlte::page')

@section('title', 'Entregas')

@section('plugins.Select2', 'true')
{{-- @section('plugins.Inputmask', 'true') --}}

@section('content_header')

@stop

@section('content')
<br>
<div class="card">
    {!! Form::open(['route'=>'admin.entregas.store', 'method'=>'post']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-light">
        <h1 class="card-title text-primary"><label>Nueva Recepcion</label></h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('conjuntoid', '* Copropiedad') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12 col-md-3">
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

            <div class="col-md-3">
                <div class="form-group"> <!-- Tipo -->
                    {{ Form::label('tipoentregaid', '* Tipo') }}
                    {!! Form::select('tipoentregaid', $tipo_entregas, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo']) !!}
                    @error('tipoentregaid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Empresa -->
                    {{ Form::label('entregaempresa', 'Empresa') }}
                    {!! Form::text('entregaempresa', null, array('placeholder' => 'Quien hace la entrega', 'class' => 'form-control')) !!}
                    @error('entregaempresa')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group"> <!-- Destinatario -->
                    {{ Form::label('entregadestinatario', '* Destinatario') }}
                    {{-- {!! Form::text('entregadestinatario', null, array('placeholder' => 'Para quien es la entrega', 'class' => 'form-control')) !!} --}}
                    {!! Form::select('entregadestinatario', [], null, ['class' => 'form-control  select2', 'data-placeholder'=>'Seleccione el destinatario', 'data-width'=>'100%']) !!}
                    @error('entregadestinatario')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Observacion -->
                    {{ Form::label('entregaobservacion', 'Observaciones') }}
                    {!! Form::textarea('entregaobservacion', null, ['class' => 'form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('entregaobservacion')
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
        <a class="btn btn-warning" href="{{route('admin.entregas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
        {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
        {!! Form::submit('Recibir', ['class'=>'btn btn-primary']) !!}
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
      //$(":input").inputmask();

      $("#unidadid").on('change', function(e) {
            var id = $( "#unidadid" ).val();
            var url = "{{ route('admin.entregas.persona', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {

                    $('#entregadestinatario').append('<option value="">seleccione un residente</option>');
                    $.each(data, function(i, res){
                        $.each(res, function(index, res1){
                            //console.log(res);
                            $('#entregadestinatario').append('<option value="'+ res1.id +'">'+ res1.personanombre +'</option>');
                        })
                    })
                },
                error: function(error){
                    console.log(error);
                    //$('#tipodocumentoid').val(1).change();
                    $('#entregadestinatario').val('');
                }
            });
      })

    })
</script>
@stop
