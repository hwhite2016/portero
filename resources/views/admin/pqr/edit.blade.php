@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Toastr', 'true')

@section('content_header')
    <h1 class="ml-3">Ticket # {{ str_pad($pqr->radicado,5,"0", STR_PAD_LEFT) }}</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="card card-outline card-primary">
        {!! Form::model($pqr, ['route'=>['admin.pqrs.update', $pqr], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('conjuntoid', $pqr->conjuntoid) !!}
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
                                            <a class="nav-link" id="custom-tabs-four-comentarios-tab" data-toggle="pill" href="#custom-tabs-four-comentarios" role="tab" aria-controls="custom-tabs-four-comentarios" aria-selected="false"> Comentarios ({{$comentarios->count()}})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-adjuntos-tab" data-toggle="pill" href="#custom-tabs-four-adjuntos" role="tab" aria-controls="custom-tabs-four-adjuntos" aria-selected="false"> Adjuntos ({{$adjuntos->count()}})</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <!-- RESUMEN TICKET -->
                                        <div class="tab-pane fade show active" id="custom-tabs-four-resumen" role="tabpanel" aria-labelledby="custom-tabs-four-resumen-tab">
                                            {{-- @include('admin.residente.indexModal') --}}
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Creado por:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    {{$pqr->bloquenombre}} / {{$pqr->unidadnombre}}<br>
                                                    <i class="fas fa-caret-right"></i> {{$pqr->name}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 p-2 border">
                                                    <span class="font-weight-bold">Asignado a:</span>
                                                </div>
                                                <div class="col-9 p-2 border">
                                                    Administración
                                                </div>
                                            </div>
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
                                                    @php
                                                        if($pqr->estadoid == 1){
                                                            $color = "secondary";
                                                        }elseif ($pqr->estadoid == 2){
                                                            $color = "warning";
                                                        }elseif ($pqr->estadoid == 3){
                                                            $color = "info";
                                                        }else{
                                                            $color = "success";
                                                        }
                                                    @endphp
                                                    <span class="text-{{$color}}"><i class="fas fa-square"></i></span>&nbsp;
                                                    @if (Auth::check() && Auth::user()->hasRole('_administrador'))
                                                        @if($pqr->estadoid != 4)
                                                            {!! Form::select('estadoid', $estados, null, ['class' => 'form-control select2', 'style'=>'width: 90%', 'data-placeholder'=>'Seleccione el estado']) !!}
                                                        @else
                                                            {{$pqr->estadonombre}}
                                                        @endif
                                                    @else
                                                        {{$pqr->estadonombre}}
                                                    @endif
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
                                        <!-- FLUJO -->
                                        <div class="tab-pane fade" id="custom-tabs-four-flujo" role="tabpanel" aria-labelledby="custom-tabs-four-flujo-tab">
                                            @foreach ($flujos as $flujo)

                                                <p><i class="fas fa-caret-right"></i> <b>{{$flujo->name}}</b> colocó el ticket en estado <span class="badge badge-{{in_array($flujo->estadoid, [1,2,3])?'secondary':'success'}}">{{$flujo->estadonombre}}</span> el {{$flujo->created_at}}
                                                    @if($flujo->motivoid)
                                                        <span class="text-danger font-italic"> --> ({{$flujo->motivo}})</span>
                                                    @endif
                                                </p>
                                            @endforeach
                                        </div>
                                        <!-- COMENTARIOS -->
                                        <div class="tab-pane fade" id="custom-tabs-four-comentarios" role="tabpanel" aria-labelledby="custom-tabs-four-comentarios-tab">
                                            @if($pqr->estadoid != 4)
                                                {{ Form::label('comentario', 'Comentarios') }} <small class="font-italic"> (Max. 400 caractéres)</small>
                                                {!! Form::textarea('comentario', null, ['class' => 'form-control' , 'rows' => 3, 'cols' => 20, 'style' => 'resize:none']) !!}
                                                @error('comentario')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                @enderror
                                            @endif
                                            <div class="mt-4" style="overflow-x: hidden; overflow-y: auto; height: 20em">
                                            @foreach ($comentarios as $comentario)

                                                <p>
                                                    @if (Auth::check() && $comentario->userid == Auth::user()->id)
                                                        <div class="callout callout-secondary">
                                                            <i class="far fa-user"></i>&nbsp; <b>{{$comentario->name}}</b> ({{$comentario->created_at}}):
                                                            <p>{{$comentario->comentario}}</p>
                                                        </div>
                                                        {{-- <span class="text-secondary"><i class="far fa-user"></i>&nbsp; <b>{{$comentario->name}}</b> ({{$comentario->created_at}}):</span> --}}
                                                    @else
                                                        <div class="callout callout-primary">
                                                            <span class="text-primary"><i class="fas fa-user-tie"></i>&nbsp; <b>{{$comentario->name}}</b> ({{$comentario->created_at}}):</span>
                                                            <p>{{$comentario->comentario}}</p>
                                                        </div>
                                                        {{-- <span class="text-primary"><i class="fas fa-user-tie"></i>&nbsp; <b>{{$comentario->name}}</b> ({{$comentario->created_at}}):</span> --}}
                                                    @endif
                                                    {{-- <br>{{$comentario->comentario}} --}}
                                                </p>

                                            @endforeach
                                            </div>

                                        </div>
                                        <!-- ADJUNTOS -->
                                        <div class="tab-pane fade" id="custom-tabs-four-adjuntos" role="tabpanel" aria-labelledby="custom-tabs-four-adjuntos-tab">
                                            <div class="card">
                                                <div class="card-footer">
                                                    Archivos Recibidos
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($adjuntos as $adjunto)
                                                        @if (Auth::check() && $adjunto->userid != Auth::user()->id)
                                                        <p><a target="_blank" href="/storage/{{$pqr->conjuntoid}}/pqrs/{{$adjunto->adjunto}}"><i class="fas fa-caret-right"></i>&nbsp; {{$adjunto->adjunto}}</a></p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-footer">
                                                    Archivos Enviados por Mi
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($adjuntos as $adjunto)
                                                        @if (Auth::check() && $adjunto->userid == Auth::user()->id)
                                                            <p><a target="_blank" href="/storage/{{$pqr->conjuntoid}}/pqrs/{{$adjunto->adjunto}}"><i class="fas fa-caret-right"></i>&nbsp; {{$adjunto->adjunto}}</a></p>
                                                        @endif
                                                    @endforeach

                                                    @if($pqr->estadoid != 4)
                                                        <hr class="mt-4">

                                                        {{ Form::file('adjunto', array('accept' => 'application/pdf,image/jpg,image/jpeg,image/png,image/svg')) }}
                                                        <br>
                                                        @error('adjunto')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                        @enderror
                                                        <br>
                                                        <small class="p-1">Max. 2MB</small> <small class="font-italic"> (Solo imagenes y archivos pdf)</small>
                                                    @endif
                                                </div>
                                            </div>

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
            @if($pqr->estadoid != 4)
                {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarUnidad']) !!}
            @endif
        </div>
        <!-- /.card-footer -->
        {!! Form::close() !!}
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
    @if(session('info'))
        <script type="text/javascript">
            toastr.success("{{session('info')}}")

            var cadena = "{{session('info')}}";
            var resumen = cadena.toLowerCase().indexOf('estado')
            var comentarios = cadena.toLowerCase().indexOf("mensaje")
            var archivos = cadena.toLowerCase().indexOf('archivo')
            if (resumen >= 0){
                $("#custom-tabs-four-resumen").addClass("show active")
                $("#custom-tabs-four-comentarios").removeClass("show active")
                $("#custom-tabs-four-resumen-tab").addClass("active")
                $("#custom-tabs-four-comentarios-tab").removeClass("active")
            }else if (comentarios >= 0){
                $("#custom-tabs-four-resumen").removeClass("show active")
                $("#custom-tabs-four-comentarios").addClass("show active")
                $("#custom-tabs-four-resumen-tab").removeClass("active")
                $("#custom-tabs-four-comentarios-tab").addClass("active")
            }else if (archivos >= 0){
                $("#custom-tabs-four-resumen").removeClass("show active")
                $("#custom-tabs-four-adjuntos").addClass("show active")
                $("#custom-tabs-four-resumen-tab").removeClass("active")
                $("#custom-tabs-four-adjuntos-tab").addClass("active")
            }

        </script>
    @endif

 <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();

      $(":input").inputmask();

    })
 </script>
@stop
