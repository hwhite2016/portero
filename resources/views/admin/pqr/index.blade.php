@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')



    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card  mt-3">
              <div class="card-header">


                <div class="row">
                    <div class="col-6 col-md-2" onclick="location.href='{{route('admin.pqrs.show', 1)}}'" style="cursor:pointer">
                        <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-secondary"><i class="far fa-envelope-open"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Abiertos</span>
                            <span class="info-box-number">{{$pqr_abierta}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-6 col-md-2" onclick="location.href='{{route('admin.pqrs.show', 2)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-warning"><i class="fas fa-sync-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">En tramite</span>
                            <span class="info-box-number">{{$pqr_proceso}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-6 col-md-2" onclick="location.href='{{route('admin.pqrs.show', 3)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-info"><i class="far fa-calendar-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Resueltos</span>
                            <span class="info-box-number">{{$pqr_resuelta}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-6 col-md-2" onclick="location.href='{{route('admin.pqrs.show', 4)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-success"><i class="far fa-envelope"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Cerrados</span>
                            <span class="info-box-number">{{$pqr_cerrada}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    @can('admin.pqrs.create')
                    <div class="col-md-4">
                        <a href="{{route('admin.pqrs.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Ticket</a>
                    </div>
                    @endcan
                </div>
                <!-- /.row -->

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pqrs" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-light">
                    <tr>
                      <th>Radicado</th>
                      <th>Asunto</th>
                      <th width="5%">...</th>


                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pqrs as $pqr)
                      <tr>
                        <td> <a class="fw-bold" href="{{route('admin.pqrs.edit', $pqr->id)}}">TK-{{ str_pad($pqr->radicado,6,"0", STR_PAD_LEFT) }}</a>
                            <br><small class="font-italic">{{ $pqr->tipopqrnombre }}</small>
                        </td>
                        <td>
                            <a href="{{route('admin.pqrs.edit', $pqr->id)}}">{{ $pqr->asunto}} </a>
                            <br><small>Fecha: {{ $pqr->created_at }}</small>
                        </td>

                        <td class="text-center">
                            @can('admin.pqrs.edit')
                                @if (Auth::check() && Auth::user()->hasRole('Residente')   )
                                    @if($pqr->estadoid != 4)

                                        {!! Form::model($pqr, ['route'=>['admin.pqrs.estado', $pqr], 'method'=>'post', 'class'=>'estado']) !!}
                                            {!! Form::hidden('estadoid', $pqr->estadoid, array('class' => 'estadoid')) !!}
                                            {!! Form::hidden('motivo', null, array('class' => 'motivo')) !!}
                                            @csrf
                                            <button class="btn btn-sm btn-danger">
                                                Cerrar Ticket
                                            </button>
                                        {!! Form::close() !!}
                                    @else
                                        <span class="text-success"><i class="fas fa-check-square"></i></span>
                                    @endif

                                @else
                                    <a class="btn btn-sm btn-info" href="{{route('admin.pqrs.edit', $pqr->id)}}">Ver Ticket </a>
                                @endif
                            @endcan
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->

@stop

@section('js')

<script type="text/javascript">

        $(document).ready(function() {
            var table = $('#pqrs').DataTable( {
              responsive: true,
              "order": [[0, 'desc']]
            } );

            new $.fn.dataTable.FixedHeader( table );

            $('[data-toggle="tooltip"]').tooltip();

        } );

 </script>


   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif

    <script>
      $('.estado').submit(function(e){
          e.preventDefault();

            var myArr = ['Seleccione un item'];
            url = "{{ route('admin.pqrs.motivo') }}";
            $.ajax({
                type: "GET",
                async: false,
                dataType: "json",
                _token: "{{csrf_token()}}",
                url: url,
                success: function(data) {
                    console.log(data.motivo);
                    $.each(data.motivo, function(i, res){
                        myArr.push(res.motivo);
                    })
                },
                error: function(error){
                    console.log(error);
                }
            });

            //var myArr = [ '1', '2', '3'];
            const { value: motivo } = Swal.fire({
                title: 'Motivo del cierre del Ticket?',
                input: 'select',
                inputOptions: myArr,
                // inputOptions: {
                //     '1': 'Se creo el ticket por error',
                //     '2': 'Solucionado !!',
                //     '3': 'Ticket no valido',
                //     '4': 'Remitido a otro ente'
                // },
                //inputPlaceholder: 'Motivo de cierre',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        console.log(value);
                        if (value != 0) {
                        //if (myArr.includes( value )) {
                            //resolve()
                            $('.motivo').val(value)
                            this.submit()
                        } else {
                           resolve('Seleccione una opcion valida')
                        }
                    })
                }
            })

      });
    </script>
@stop
