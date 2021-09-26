@extends('adminlte::page')

@section('title', 'Organigrama')

@section('plugins.Select2', 'true')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item text-primary"><a href="{{route('admin.reservas.index')}}">Organigrama</a></li>
            <li class="breadcrumb-item active">Mi Conjunto</li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
@stop

@section('content')

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

@stop
