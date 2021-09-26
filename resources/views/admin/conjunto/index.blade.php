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
        <div class="col-12 col-md-6">
            <div class="card">

                <img src="/storage/{{ $conjunto->conjuntologo }}" width="250px" class="card-img" alt="...">
                <div class="card-body">
                    <span class="float-right badge {{$conjunto->conjuntoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$conjunto->conjuntoestado == 1 ? 'Activo' : 'Inactivo'}}</span>
                    <small class="card-text text-muted">{{ $conjunto->barrionombre }}</small><br>
                    <label class="card-title">{{ $conjunto->conjuntonombre }}</label>
                    <p class="card-text">{{ $conjunto->conjuntodireccion }}</p>
                    <small class="text-muted"><b>Administración:</b></small>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted"><i class="far fa-envelope"></i> {{ $conjunto->conjuntocorreo }}</small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted"><i class="fas fa-mobile-alt"></i> {{ $conjunto->conjuntocelular }}</small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted"><i class="fas fa-phone-volume"></i> {{ $conjunto->conjuntotelefono }}</small>
                        </div>
                    </div>

                    <hr style="color: rgb(209, 208, 208)">
                    <small class="text-muted"><b>Correo Consejo de Administración:</b></small>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted"><i class="far fa-envelope"></i> {{ $conjunto->conjuntocorreoconsejo }}</small>
                        </div>
                    </div>
                    <small class="text-muted"><b>Correo Comité de Convivencia:</b></small>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted"><i class="far fa-envelope"></i> {{ $conjunto->conjuntocorreocomite }}</small>
                        </div>
                    </div>

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
