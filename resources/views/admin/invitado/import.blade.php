@extends('adminlte::page')

@section('title', 'Invitados')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<div class="flex-center position-ref full-height">

    <div class="container mt-5">
        <h3>Importar Lista de Invitados</h3>

        @if ( $errors->any() )

            <div class="alert alert-danger">
                @foreach( $errors->all() as $error )<li>{{ $error }}</li>@endforeach
            </div>
        @endif

        @if(isset($numRows))
            <div class="alert alert-sucess">
                Se importaron {{$numRows}} registros.
            </div>
        @endif

        <form action="{{route('admin.invitados.import')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-3">
                    <div class="custom-file">
                        <input type="file" name="invitados" class="custom-file-input" id="invitados">
                        <label class="custom-file-label" for="invitados">Seleccionar archivo</label>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->

@stop

@section('js')

@stop
