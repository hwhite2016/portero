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
            <label>Reservas</label>
        </h1>
        {{-- @can('admin.zonas.create')
            <a href="{{route('admin.reservas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Reserva</a>
        @endcan --}}
        {{-- @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="fas fa-swimmer"></i> &nbsp Mis reservas</a>
        @endcan --}}
        <a class="btn btn-primary float-right mr-2" href="{{route('admin.zonas.index')}}"><i class="fas fa-swimmer"></i> Zonas Comunes</a>

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            @php
                setlocale(LC_TIME, "spanish");
                $dias = array('Dom','Lun','Mar','Mié','Jue','Vie','Sáb');
                $meses = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
                $cont = 1

            @endphp
            @if(!$reservas->count())
                <div class="col-12">
                    <div class='alert alert-default-warning' role='alert'>
                        <i class='fas fa-exclamation-triangle'></i>
                        &nbsp; No hay reservas pendientes, para realizar una reserva vaya a <a class="text-primary" href="{{route('admin.zonas.index')}}">zonas comunes</a>
                    </div>
                </div>
            @endif
            @foreach ($reservas as $reserva)
                @php
                    if($cont <= 3){
                        $collapsed = "";
                        $icon = "minus";
                    }else{
                        $collapsed = "collapsed-card";
                        $icon = "plus";
                    }
                @endphp
                <div class="col-12 col-md-4">
                    <div class="card shadow-lg {{$collapsed}}">
                        <div class="card-header">
                            <h3 class="card-title"><i class="far fa-calendar-check"></i>&nbsp; {{ $dias[date('w', strtotime($reserva->reservafecha))] }}, {{date('j', strtotime($reserva->reservafecha))}} de {{ $meses[date('n', strtotime($reserva->reservafecha)) - 1] }} | {{ date('g:i', strtotime($reserva->reservahora)) }} - {{ date('g:i a', strtotime($reserva->reservahorafin)) }}  </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{$icon}}"></i>
                                </button>

                            </div>
                            <!-- /.card-tools -->
                            <span class="float-right mt-1 mr-2 badge {{$reserva->reservaestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$reserva->reservaestado == 1 ? 'Activa' : 'Expirada'}}</span>

                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <label class="card-title">{{$reserva->zonanombre}}</label>
                                    <p class="card-text">
                                        <i class="fas fa-caret-right"></i> {{$reserva->unidadnombre}} &nbsp; - &nbsp; <b>{{$reserva->reservacupos}}</b> Cupo(s)<br>
                                        <i class="fas fa-caret-right"></i> Codigo de la reserva: <b class="text-primary">{{$reserva->reservacodigo}}</b><br>
                                        <i class="fas fa-caret-right"></i> Valor de la Reserva: <b>$ {{$reserva->valor}}</b>
                                    </p>
                                    @if($reserva->zonacompartida == 0)
                                        <a href="{{route('admin.invitados.importForm', $reserva->id)}}" class="text-primary float-right"><span class="font-italic"><i class="fas fa-caret-right"></i> Ver lista de invitados</span></a>
                                    @endif
                                </div>
                                {{-- <div class="col-3">
                                    <div class="title m-b-md">
                                        {!!QrCode::size(70)->color(170, 170, 170)->generate($reserva->reservacodigo) !!}
                                    </div>
                                </div> --}}
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                            @can('admin.reservas.destroy')
                              {!! Form::model($reserva, ['route'=>['admin.reservas.destroy', $reserva], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @csrf
                              {!! Form::hidden('zonaid', $reserva->zonaid) !!}
                              {!! Form::hidden('reservafecha', $reserva->reservafecha) !!}
                              {!! Form::hidden('reservahora', $reserva->reservahora) !!}
                              {{-- @method('DELETE') --}}

                              <button class="btn btn-sm btn-block btn-outline-danger float-right"><i class="fas fa-ban"></i> Eliminar Reserva</button>
                              {!! Form::close() !!}
                            @endcan

                        </div>
                        <!-- /.card-footer -->

                    </div>
                    <!-- /.card-->
                </div>
                @php
                    $cont++
                @endphp
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

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
