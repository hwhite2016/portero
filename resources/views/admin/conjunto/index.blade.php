@extends('adminlte::page')

@section('title', 'Conjuntos')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="row">
    @foreach ($conjuntos as $conjunto)
        <div class="col-12 col-md-8">
            <div class="card">

                <img src="/storage/{{ $conjunto->conjuntologo }}" width="250px" class="card-img" alt="...">
                <div class="card-body">
                    <span class="float-right badge {{$conjunto->conjuntoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$conjunto->conjuntoestado == 1 ? 'Activo' : 'Inactivo'}}</span>
                    <small class="card-text text-muted">{{ $conjunto->barrionombre }}</small><br>
                    <label class="card-title">{{ $conjunto->conjuntonombre }}</label> <small class="ml-1">( 594 Unidades )</small><br>
                    <div class="card-text">{{ $conjunto->conjuntodireccion }}</div>
                    <div class="card-text"><i class="fas fa-phone-volume"></i> Portería: {{ $conjunto->conjuntocelular }} - {{ $conjunto->conjuntotelefono }}</div>

                    @foreach ($organos as $organo)
                        <div class="border-bottom" style="height: 0.5em"></div>
                        <small class="text-muted"><b><u>{{ $organo->organonombre }}:</u></b></small>
                        <div class="row">
                            @if($organo->organocorreo)
                            <div class="col-12">
                                <small class="text-muted"><i class="far fa-envelope"></i>
                                    <span class="text-primary">
                                        {{ $organo->organocorreo }}
                                        @if($organo->organopqr)
                                            <a class="text-primary float-right" href="{{route('admin.pqrs.create')}}"><u>Enviar PQR</u></a>
                                        @endif
                                    </span>
                                </small>
                            </div>
                            @endif
                            <div class="col-12">
                                @if($organo->organocelular)
                                    <small class="text-muted"><i class="fas fa-mobile-alt"></i> {{ $organo->organocelular }}</small>
                                @endif
                                @if($organo->organotelefono)
                                    <small class="text-muted ml-3"><i class="fas fa-phone-volume"></i> {{ $organo->organotelefono }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- /.card-body -->
                @if ($conjunto->conjuntoestado == 1)
                    <div class="card-footer">
                        @can('admin.conjuntos.destroy')
                        {!! Form::model($conjunto, ['route'=>['admin.conjuntos.destroy', $conjunto], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                        @endcan
                        @can('admin.conjuntos.edit')
                            <a href="{{ route ('admin.bloques.show', $conjunto->id) }}" class="btn btn-warning btn-sm  float-right"  id="btn-bloque" data-toggle="tooltip" title="Ver Bloques"><i class="fas fa-building"></i> ({{ $conjunto->bloque_count }})</a>
                            <a href="{{route('admin.conjuntos.edit', $conjunto)}}" class="btn btn-sm btn-info  float-right mr-2" data-toggle="tooltip" title="Editar Conjunto">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan
                        {{-- @can('admin.zonas.zonacomun')
                            <a href="{{route('admin.zonas.index')}}" class="btn btn-sm btn-info  float-right mr-2" data-toggle="tooltip" title="Zonas Comunes">
                                <i class="fas fa-swimmer"></i>
                            </a>
                        @endcan --}}
                        @can('admin.conjuntos.destroy')
                        @csrf
                        {{-- @method('DELETE') --}}
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Conjunto"><i class="far fa-trash-alt"></i></button>
                        {!! Form::close() !!}
                        @endcan
                    </div>
                    <!-- /.card-footer -->
                @endif
            </div>
            <!-- /.card-->
        </div>
    @endforeach

    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header bg-light">
                <i class="fas fa-caret-right"></i> <b>Comunicados</b>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @forelse ($comunicados as $comunicado)
                    <span class="text-secondary">
                    @if($comunicado->tipoanuncioid == 1) {{-- Anuncio --}}
                        <i class="fas fa-volume-up"></i>
                    @elseif($comunicado->tipoanuncioid == 2) {{-- Invitacion --}}
                        <i class="far fa-envelope"></i>
                    @elseif($comunicado->tipoanuncioid == 3) {{-- Llamado de atencion --}}
                        <i class="far fa-file-alt"></i>
                    @elseif($comunicado->tipoanuncioid == 4) {{-- Recordatorio --}}
                    <i class="far fa-calendar-check"></i>
                    @elseif($comunicado->tipoanuncioid == 5) {{-- Felicitacion --}}
                        <i class="fas fa-award"></i>
                    @else
                        <i class="fas fa-volume-up"></i>
                    @endif
                        <b>{{$comunicado->tipoanuncionombre}}</b>
                    </span>
                    <small class="text-muted float-right">
                        {{ Carbon\Carbon::parse($comunicado->anunciofechaentrega)->diffForHumans() }}
                    </small>
                    <br>
                    <span class="text-muted">
                        <a href="{{route('admin.anuncios.show', $comunicado->id)}}">
                            {{$comunicado->anuncionombre}}
                        </a>
                        @if($comunicado->anuncioadjunto)
                            <small class="float-right">
                                <a class=" text-secondary" target="_blank" href="/storage/{{$comunicado->conjuntoid}}/comunicados/{{$comunicado->anuncioadjunto}}">
                                    [ <i class="fas fa-download"></i> ]
                                </a>
                            </small>
                        @endif
                    </span>

                    <div class="border-bottom" style="height: 0.5em"></div>
                @empty
                    <div class="ml-2">No hay comunicados recientes.</div>

                @endforelse
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

</div>
<!-- /.row-->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        } );
    </script>

    @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
    @endif

@stop
