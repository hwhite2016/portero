@extends('adminlte::page')

@section('title', 'Unidades')

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

                @can('admin.unidads.create')
                {!! Form::open(['route'=>'admin.unidads.create', 'method'=>'get']) !!}
                @if (isset($id))
                    {!! Form::hidden('bloqueid', $id) !!}
                @endif
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Unidad</button>
                {!! Form::close() !!}
                @endcan
                <a class="btn btn-warning float-right mr-2" data-toggle="tooltip" title="Ver residentes" href="{{route('admin.residentes.index')}}"><i class="fas fa-angle-double-right"></i></a>
                <a class="btn btn-warning float-right mr-2" data-toggle="tooltip" title="Ver bloques" href="{{route('admin.bloques.index')}}"><i class="fas fa-angle-double-left"></i></a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="unidads" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-light">
                    <tr>
                      <th>Unidad</th>
                      <th>Bloque</th>
                      <th>Tipo</th>
                      <th width="15%">Estado</th>
                      <th width="10%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($unidads as $unidad)
                      <tr>
                        <td> {{ $unidad->unidadnombre }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $unidad->bloquenombre }} </label>
                          {{-- <small> ({{ $unidad->conjuntonombre }}) </small> --}}
                        </td>
                        <td> {{ $unidad->claseunidadnombre }}
                             <small> ({{ $unidad->claseunidaddescripcion }})</small>
                        </td>
                        <td>
                            @if($unidad->estado_id == 1)
                                <span class="badge bg-light">Sin Registro</span>
                            @elseif($unidad->estado_id == 2)
                                <span class="badge bg-secondary"><i class="fas fa-cog"></i> En Proceso</span>
                            @elseif($unidad->estado_id == 3)
                                <span class="badge bg-info"><i class="fas fa-spell-check"></i> Por Verificar</span>
                            @elseif($unidad->estado_id == 4)
                                <span class="badge bg-success"><i class="fas fa-check"></i> Verificado</span>
                            @endif

                        </td>
                        <td>
                            @can('admin.unidads.destroy')
                              {!! Form::model($unidad, ['route'=>['admin.unidads.destroy', $unidad], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan
                              <a href="{{ route ('admin.residentes.show', $unidad->id) }}" class="btn btn-default btn-sm"  id="btn-unidad" data-toggle="tooltip" title="Ver Residentes"><i class="fas fa-user"></i> ({{ $unidad->residente_count }})</a>

                              @can('admin.unidads.edit')
                              @if (isset($id))
                                <a href="{{route('admin.unidads.edit', $unidad->id)}}?bloqueid={{$id}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Unidad">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                              @else
                                <a href="{{route('admin.unidads.edit', $unidad->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Unidad">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                              @endif
                              @endcan

                              @can('admin.unidads.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Unidad"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#unidads').DataTable( {
                lengthChange: false,
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'Unidades'
                    }
                ],
                responsive: true,
                "displayLength": 25,
            } );
            table.buttons().container()
                .appendTo( '#unidads_wrapper .col-md-6:eq(0)' );
            new $.fn.dataTable.FixedHeader( table );
            $('[data-toggle="tooltip"]').tooltip();



            // var groupColumn = 1;
            // var table = $('#unidads').DataTable({

            //     lengthChange: false,
            //     buttons: [
            //         {
            //             text: '<i class="far fa-file-excel"></i> Excel',
            //             extend: 'excel',
            //             title: 'Unidades'
            //         }
            //     ],
            //     responsive: true,
            //     "columnDefs": [
            //         { "visible": false, "targets": groupColumn }
            //     ],
            //     "order": [[ groupColumn, 'asc' ]],
            //     "displayLength": 25,
            //     "drawCallback": function ( settings ) {
            //         var api = this.api();
            //         var rows = api.rows( {page:'current'} ).nodes();
            //         var last=null;

            //         api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
            //             if ( last !== group ) {
            //                 $(rows).eq( i ).before(
            //                     '<tr class="group"><td colspan="5">'+group+'</td></tr>'
            //                 );

            //                 last = group;
            //             }
            //         } );
            //     }
            // } );

            // table.buttons().container()
            //     .appendTo( '#unidads_wrapper .col-md-6:eq(0)' );

            // // Order by the grouping
            // $('#unidads tbody').on( 'click', 'tr.group', function () {
            //     var currentOrder = table.order()[0];
            //     if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            //         table.order( [ groupColumn, 'desc' ] ).draw();
            //     }
            //     else {
            //         table.order( [ groupColumn, 'asc' ] ).draw();
            //     }
            // } );

            // new $.fn.dataTable.FixedHeader( table );
            // $('[data-toggle="tooltip"]').tooltip();
        } );

     </script>

   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif
   @if(session('error'))
    <script type="text/javascript">
        toastr.error("{{session('error')}}")
    </script>
   @endif

   <script>
      $('.frm_delete').submit(function(e){
          e.preventDefault();

          Swal.fire({
            title: 'Esta usted seguro de eliminar este registro?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            progressBar: true,
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
