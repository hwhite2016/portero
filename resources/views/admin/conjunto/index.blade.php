@extends('adminlte::page')

@section('title', 'Conjuntos')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<div class="row">
    @foreach ($conjuntos as $conjunto)
        <div class="col-12 col-md-5">
            <div class="card">

                <img src="/storage/{{ $conjunto->conjuntologo }}" width="250px" class="card-img" alt="...">
                <div class="card-body">
                    <span class="float-right badge {{$conjunto->conjuntoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$conjunto->conjuntoestado == 1 ? 'Activo' : 'Inactivo'}}</span>
                    <small class="card-text text-muted">{{ $conjunto->barrionombre }}</small><br>
                    <label class="card-title">{{ $conjunto->conjuntonombre }}</label><br>
                    <div class="card-text">{{ $conjunto->conjuntodireccion }}</div>
                    <div class="row">
                        <div class="col-2">
                            <small class="text-muted"><i class="fas fa-phone-volume"></i> Portería:</small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">
                                {{ $conjunto->conjuntocelular }} - {{ $conjunto->conjuntotelefono }}
                            </small>
                        </div>
                    </div>

                    @foreach ($organos as $organo)
                        <div class="border-bottom" style="height: 0.5em"></div>
                        <small class="text-muted"><b><u>{{ $organo->organonombre }}:</u></b></small>
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted"><i class="far fa-envelope"></i>
                                    <a href="{{route('admin.pqrs.create')}}">{{ $organo->organocorreo }}</a>
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted"><i class="fas fa-mobile-alt"></i> {{ $organo->organocelular }}</small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted"><i class="fas fa-phone-volume"></i> {{ $organo->organotelefono }}</small>
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
