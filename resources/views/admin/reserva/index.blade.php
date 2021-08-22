@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title text-primary">
            Mis reservas
        </h1>
        @can('admin.zonas.create')
            <a href="{{route('admin.reservas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Reserva</a>
        @endcan
        {{-- @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="fas fa-swimmer"></i> &nbsp Mis reservas</a>
        @endcan --}}
        <a class="btn btn-warning float-right mr-2" href="{{route('admin.index')}}"><i class="fas fa-home"></i> Home</a>
        <a class="btn btn-warning float-right mr-2" href="{{route('admin.zonas.index')}}"><i class="fas fa-angle-double-left"></i></a>

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            @foreach ($reservas as $reserva)
                <div class="col-12 col-md-4">
                    <div class="card card card-primary shadow-lg {{($reservas->count()<=3?'':'collapsed-card')}}">
                        <div class="card-header">
                            <h3 class="card-title"><i class="far fa-calendar-check"></i>&nbsp; {{ $reserva->reservafecha }} | {{ $reserva->reservahora }} </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{($reservas->count()<=3?'minus':'plus')}}"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->

                        </div>
                        <div class="card-body">
                            <label class="card-title">{{$reserva->zonanombre}}</label>
                            <p class="card-text">
                                <i class="fas fa-caret-right"></i> Codigo de la reserva: <b class="text-primary">{{$reserva->reservacodigo}}</b><br>
                                <i class="fas fa-caret-right"></i> Cupos: <b>{{$reserva->reservacupos}}</b>
                            </p>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            @can('admin.reservas.destroy')
                              {!! Form::model($reserva, ['route'=>['admin.reservas.destroy', $reserva], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger float-right"><i class="fas fa-ban"></i> Cancelar Reserva</button>
                              {!! Form::close() !!}
                            @endcan

                        </div>
                        <!-- /.card-footer -->

                    </div>
                    <!-- /.card-->
                </div>
            @endforeach
        </div>
        <!-- /.row-->
    </div>
    <!-- /.card-body-->
</div>
<!-- /.card-->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

    @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
    @endif

    <script>
        $('.frm_delete').submit(function(e){
            e.preventDefault();

            Swal.fire({
              title: 'Esta usted seguro de eliminar este registro?',
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
