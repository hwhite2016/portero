@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')

@section('content_header')
    <h1 class="ml-3">Ticket # {{ str_pad($pqr->radicado,5,"0", STR_PAD_LEFT) }}</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <!-- TAB -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-resumen-tab" data-toggle="pill" href="#custom-tabs-four-resumen" role="tab" aria-controls="custom-tabs-four-resumen" aria-selected="true"> Resumen</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-flujo-tab" data-toggle="pill" href="#custom-tabs-four-flujo" role="tab" aria-controls="custom-tabs-four-flujo" aria-selected="false"> Flujo</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-comentarios-tab" data-toggle="pill" href="#custom-tabs-four-comentarios" role="tab" aria-controls="custom-tabs-four-comentarios" aria-selected="false"> Comentarios</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-adjuntos-tab" data-toggle="pill" href="#custom-tabs-four-adjuntos" role="tab" aria-controls="custom-tabs-four-adjuntos" aria-selected="false"> Adjuntos</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-four-resumen" role="tabpanel" aria-labelledby="custom-tabs-four-resumen-tab">
                                            {{-- @include('admin.residente.indexModal') --}}
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Tipo:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->tipopqrnombre}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Asunto:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->asunto}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Fecha:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->created_at}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Estado:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->estadonombre}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Detalle:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->mensaje}}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-flujo" role="tabpanel" aria-labelledby="custom-tabs-four-flujo-tab">
                                            @foreach ($flujos as $flujo)
                                                <p><i class="fas fa-caret-right"></i> <b>{{$flujo->name}}</b> colocó el ticket en estado <span class="badge badge-secondary">{{$flujo->estadonombre}}</span> el {{$flujo->created_at}}</p>
                                            @endforeach
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-comentarios" role="tabpanel" aria-labelledby="custom-tabs-four-comentarios-tab">


                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-adjuntos" role="tabpanel" aria-labelledby="custom-tabs-four-adjuntos-tab">


                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.TAB -->

                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a class="btn btn-warning" href="{{route('admin.pqrs.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
            {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
            {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarUnidad']) !!}
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</div>
<!-- /.container-fluid -->

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

    })
</script>
@stop
