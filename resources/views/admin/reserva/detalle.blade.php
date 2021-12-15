@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Timepicker', 'true')
@section('plugins.Toastr', 'true')

@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')
<br>
<div class="card">

    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Nueva Reserva</label>
        </h1>
        @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="far fa-calendar-check"></i> &nbsp Mis reservas</a>
        @endcan
        <a class="btn btn-warning float-right mr-2" href="{{route('admin.zonas.index')}}"><i class="fas fa-angle-double-left"></i></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
Detalle de la reserva
{{$item->zonaid}}

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {{-- <a class="btn btn-warning" href="{{route('admin.reservas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a> --}}
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
