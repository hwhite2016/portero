@extends('adminlte::page')

@section('title', 'Entregas')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <a class="btn btn-warning float-right mr-2" href="{{route('admin.seguimiento.index')}}"><i class="fas fa-clock"></i> Pendientes</a>
                <a class="btn btn-success float-right mr-2" href="{{route('admin.seguimiento.show', '!=')}}"><i class="fas fa-check"></i> Recibidos</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="entregas" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Tipo</th>
                      <th>Unidad</th>
                      <th>Fecha Recepción</th>
                      <th>Receptor</th>
                      <th>Empresa</th>
                      <th>Destinatario</th>
                      <th>Fecha entrega</th>
                      <th>Observación</th>
                      <th width="5%">Estado</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($entregas as $entrega)
                      <tr>
                        <td> {{ $entrega->tipoentreganombre }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $entrega->unidadnombre }} </label>
                          <small> ({{ $entrega->bloquenombre }}) </small>
                        </td>
                        <td> {{ $entrega->created_at }} </td>
                        <td> {{ $entrega->entregareceptor }} </td>
                        <td> {{ $entrega->entregaempresa }} </td>
                        <td> {{ $entrega->personanombre }} </td>
                        <td> {{ $entrega->entregafechaentrega }} </td>
                        <td> {{ $entrega->entregaobservacion }} </td>

                        <td>


                            @if($entrega->entregaestado == 0)
                                @can('admin.seguimiento.edit')
                                @if($entrega->entregafechaentrega <> null) {{-- Entregado al residente --}}
                                     {!! Form::model($entrega, ['route'=>['admin.entregas.update', $entrega], 'method'=>'put', 'class'=>'frm_update']) !!}
                                        <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Confirmar recepción">
                                            <i class="fas fa-cog"></i> Confirmar
                                        </button>
                                    {!! Form::close() !!}

                                @else {{-- Aun en recepcion --}}
                                    <button class="btn btn-sm btn-danger" disabled>
                                        <i class="fas fa-concierge-bell"></i> En recepción
                                    </button>
                                    {{-- <small class="text-danger"><i class="fas fa-concierge-bell"></i> En recepción</small> --}}
                                @endif
                                @endcan
                            @else
                                <button class="btn btn-sm btn-success" disabled>
                                    <i class="fas fa-check-circle"></i> Recibido
                                </button>
                            @endif

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



    <style type="text/css">
      tr.group,
      tr.group:hover {
          background-color: #ddd !important;
      }
    </style>
@stop

@section('js')

     <script type="text/javascript">


        $(document).ready(function() {
            var groupColumn = 1;
            var table = $('#entregas').DataTable({
                lengthChange: false,
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'ENTREGAS'
                    }
                ],
                responsive: true,
                "columnDefs": [
                    { "visible": false, "targets": groupColumn }
                ],
                "order": [[ groupColumn, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }

            } );

            table.buttons().container()
                .appendTo( '#entregas_wrapper .col-md-6:eq(0)' );


            // Order by the grouping
            $('#entregas tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                    table.order( [ groupColumn, 'desc' ] ).draw();
                }
                else {
                    table.order( [ groupColumn, 'asc' ] ).draw();
                }
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
      $('.frm_update').submit(function(e){
          e.preventDefault();

          Swal.fire({
            title: 'El concerge le hizo la entrega satisfactoriamente?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, seguro!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          })
      });

   </script>
@stop
