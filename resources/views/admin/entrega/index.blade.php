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
                <h3 class="card-title">
                    {{-- <a href="{{route('admin.index')}}"><i class="fas fa-house-user"></i> Ir al Home</a> --}}
                </h3>
                @can('admin.entregas.create')
                <a href="{{route('admin.entregas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Recepción</a>
                @endcan
                <a class="btn btn-warning float-right mr-2" href="{{route('admin.entregas.show', '=')}}"><i class="fas fa-clock"></i> Pendientes</a>
                <a class="btn btn-success float-right mr-2" href="{{route('admin.entregas.show', '!=')}}"><i class="fas fa-check"></i> Entregados</a>
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
                      <th width="5%">...</th>

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


                              @can('admin.entregas.edit')
                              {!! Form::model($entrega, ['route'=>['admin.entregas.update', $entrega], 'method'=>'put', 'class'=>'frm_update']) !!}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Entregar"><i class="fas fa-sign-out-alt"></i></button>
                              {!! Form::close() !!}
                              @endcan

                            @can('admin.entregas.destroy')
                              {!! Form::model($entrega, ['route'=>['admin.entregas.destroy', $entrega], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Entrega"><i class="far fa-trash-alt"></i></button>

                              {!! Form::close() !!}
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
                        title: 'entregas'
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
