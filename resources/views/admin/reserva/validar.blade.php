@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
@php
require __DIR__ . "/vendor/autoload.php";
$qrcode= new QrReader($_FILES['qrimage']['tmp_name']);
$text= $qrcode->text();
@endphp

<form action="decode.php" method="post" enctype="multipart/form-data">
    <input type="file" name="qrimage" id="qrimage" class="form-control" required=""><br>
    <input type="submit" class="btn btn-md btn-block btn-info" value="Enviar datos" name="">

</form>

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

@stop
