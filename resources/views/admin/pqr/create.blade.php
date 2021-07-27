@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear pqrs/h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::open(['route'=>'admin.pqrs.store', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO TICKET</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('conjuntoid', 'Copropiedad') }}
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
                    {{ Form::label('tipopqrid', 'Tipo de Ticket') }}
                    {!! Form::select('tipopqrid', $tipo_pqrs, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el tipo de Ticket']) !!}
                    @error('tipopqrid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('asuntoid', 'Asunto') }}
                    {!! Form::select('asuntoid', $asuntos, null, ['class' => 'form-control select2','style'=>'width: 100%','data-placeholder'=>'Seleccione el asunto']) !!}
                    @error('asuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror

                </div>
            </div>

            <div class="col-12">
                <div class="form-group"> <!-- Detalle del caso -->
                    {{ Form::label('mensaje', 'A continuación detalle su caso') }}
                    {!! Form::textarea('mensaje', null, ['class' => 'form-control' , 'rows' => 4, 'cols' => 20, 'style' => 'resize:none']) !!}
                    @error('mensaje')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>



            <div class="col-12">
                <div class="form-group"> <!-- Logo del conjunto -->

                        <div class="btn btn-default btn-file">
                          <i class="fas fa-paperclip"></i> Adjuntar Imagen o PDF
                          {{ Form::file('archivo', array('accept' => 'application/pdf,image/jpg,image/jpeg,image/png,image/svg', 'class' => 'form-control')) }}
                        </div>
                        <p class="text-sm">Max. 32MB</p>

                    @error('archivo')
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
        <a class="btn btn-warning" href="{{route('admin.pqrs.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
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

    })

</script>
@stop
