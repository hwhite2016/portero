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

    <div class="card-header bg-light">

        <h1 class="card-title text-primary">
            @if($anuncio->tipoanuncioid == 1) {{-- Anuncio --}}
                <i class="fas fa-volume-up"></i>
            @elseif($anuncio->tipoanuncioid == 2) {{-- Invitacion --}}
                <i class="far fa-envelope"></i>
            @elseif($anuncio->tipoanuncioid == 3) {{-- Llamado de atencion --}}
                <i class="far fa-file-alt"></i>
            @elseif($anuncio->tipoanuncioid == 4) {{-- Recordatorio --}}
            <i class="far fa-calendar-check"></i>
            @elseif($anuncio->tipoanuncioid == 5) {{-- Felicitacion --}}
                <i class="fas fa-award"></i>
            @else
                <i class="fas fa-volume-up"></i>
            @endif
            <label>{{$anuncio->tipoanuncionombre}}</label>
        </h1>
        <a class="btn btn-default float-right" href="{{route('admin.index')}}"><i class="fas fa-angle-double-left"></i></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h3>{{$anuncio->anuncionombre}}</h3>
            </div>
            <div class="col-md-2">
                <small class="text-muted float-right">
                    {{ Carbon\Carbon::parse($anuncio->anunciofechaentrega)->diffForHumans() }}
                </small>
            </div>
        </div>


        @if($anuncio->anuncioadjunto)
            @php
                $formato = strtolower(substr($anuncio->anuncioadjunto, strpos($anuncio->anuncioadjunto, '.')+1))
            @endphp
            @if($formato == 'pdf')
                <a href="/storage/{{$anuncio->conjuntoid}}/comunicados/{{$anuncio->anuncioadjunto}}" target="_blank"><i class="fas fa-download"></i> {{$anuncio->anuncioadjunto}}</a><br>
                <div class="mt-4 text-justify">
                    @php
                        echo nl2br($anuncio->anunciodescripcion)
                    @endphp
                </div>
            @else
                <div class="row">
                    <div class="col-md-7">
                        <img src="/storage/{{$anuncio->conjuntoid}}/comunicados/{{$anuncio->anuncioadjunto}}" width="100%" />
                    </div>
                    <div class="col-md-5">
                        <div class="text-justify">
                            @php
                                echo nl2br($anuncio->anunciodescripcion)
                            @endphp
                        </div>
                    </div>
                </div>

            @endif
        @endif


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-warning" href="{{route('admin.index')}}"><i class="fas fa-angle-double-left"></i> Volver</a>
    </div>
    <!-- /.card-footer -->
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

@stop
