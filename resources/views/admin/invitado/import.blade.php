@extends('adminlte::page')

@section('title', 'Invitados')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item text-primary"><a href="{{route('admin.reservas.index')}}">Mis Reservas</a></li>
            <li class="breadcrumb-item active">Importar lista de invitados</li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h5><label>{{$reserva->zonanombre}}</label> ({{$reserva->unidadnombre}})</h5>
    </div>
    <div class="card-body">
        {!! Form::open(['route'=>'admin.invitados.import', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
        @csrf
        <div class="row">
            <div class="col-md-6">
                Codigo de Reserva: <label class="text-primary">{{$reserva->reservacodigo}}</label> | Total invitados: <b>{{$total_invitados}}</b>
            </div>

            <div class="col-md-4">

                <div class="form-group"> <!-- Logo del conjunto -->
                    {!! Form::hidden('reservaid', $reserva->id) !!}
                    {{ Form::file('invitados', array('accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel')) }}
                    @error('invitados')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                    <br><a href="#" class="text-success" data-placement="bottom"  tabindex="0" data-toggle="popover" data-trigger="focus" data-popover-content="#a2">
                        <i class="fas fa-file-excel"></i> <u><b>Descargar Plantilla Excel</b></u>
                    </a>
                </div>

            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-file-excel"></i> Importar archivo</button>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content for Popover -->
        <div id="a2" class="d-none popover">
            <div class="popover-heading"><i class="far fa-file-excel"></i> &nbsp; <b>Plantilla Excel</b></div>

            <div class="popover-body">
                <div class='row'>
                    <div class='col-12 text-justify'>
                        Descargue la plantilla de excel, ingrese la lista de invitados tal como lo indica dicha plantilla y subala haciendo click en el boton <b>importar archivo</b> que se encuentra a la derecha.
                    </div>
                    <div class='col-12'><hr><a target="_blank" href="/storage/plantillas/Lista_de_invitados.xlsx" class="text-success float-right"><i class="fas fa-upload"></i> Descargar Plantilla Excel</a></div>
                </div>
             </div>
        </div>
        <!-- /.Content for Popover -->

        {!! Form::close() !!}
        <div class="row">
            <div class="col-12">

                @if ( $errors->any() )
                    <div class='alert alert-default-danger alert-dismissible fade show' role='alert'>
                        @foreach( $errors->all() as $error )<li>{{ $error }}</li>@endforeach
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                @endif

                @if(isset($numRows))
                <div class='alert alert-default-success alert-dismissible fade show' role='alert'>
                    <i class='fas fa-check'></i>&nbsp; Se importaron {{$numRows}} registros.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                @endif
                <a class="btn btn-sm btn-default mb-2 mt-1" href="{{ route('admin.invitados.export', $reserva->id) }}"><i class="far fa-file-excel"></i> Exportar Lista</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Edad</th>
                        <th>Celular</th>
                        <th style="width: 10px">...</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invitados as $invitado)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$invitado->invitadodocumento}}</td>
                            <td>{{$invitado->invitadonombre}}</td>
                            <td>{{$invitado->invitadoedad}}</td>
                            <td>{{$invitado->invitadocelular}}</td>
                            <td>
                                {{-- @can('admin.invitados.destroy') --}}
                                {!! Form::model($invitado, ['route'=>['admin.invitados.destroy', $invitado], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                @csrf
                                <button class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                {!! Form::close() !!}
                                {{-- @endcan --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <div class="card-footer">

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script>
    $(function () {

        $("[data-toggle=popover]").popover({
            html : true,
            container: 'body',
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
                },
                title: function() {
                var title = $(this).attr("data-popover-content");
                return $(title).children(".popover-heading").html();
            }
        });
    })
</script>

<script>
    $('.frm_delete').submit(function(e){
        e.preventDefault();

        Swal.fire({
          title: 'Esta usted seguro de eliminar este invitado?',
          text: "Esta accion no se podra deshacer!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit();
          }
        })
    });

 </script>

@stop
