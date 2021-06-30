@extends('adminlte::page')

@section('title', 'Bloques')

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
                  <a href="{{route('admin.index')}}"><i class="fas fa-house-user"></i> Ir al Home</a>
                </h3>
                @can('admin.bloques.create')
                <a href="{{route('admin.bloques.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Bloque</a>
                @endcan
                <a class="btn btn-warning float-right mr-2" href="{{route('admin.conjuntos.index')}}"><i class="fas fa-arrow-left"></i> Conjuntos</a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="bloques" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Bloque/Torre/Manzana/Etapa</th>
                      <th>Conjunto</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($bloques as $bloque)
                      <tr>
                        <td> {{ $bloque->bloquenombre }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $bloque->conjuntonombre }} </label>
                          <small> ({{ $bloque->barrionombre }}) </small>
                        </td>
                         <td>
                            @can('admin.bloques.destroy')
                              {!! Form::model($bloque, ['route'=>['admin.bloques.destroy', $bloque], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan

                              <a href="{{ route ('admin.unidads.show', $bloque->id) }}" class="btn btn-warning btn-sm"  id="btn-unidad" data-toggle="tooltip" title="Ver Unidades"><i class="fas fa-home"></i> ({{ $bloque->unidad_count }})</a>

                              @can('admin.bloques.edit')
                              <a href="{{route('admin.bloques.edit', $bloque->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Bloque">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @endcan

                              @can('admin.bloques.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Bloque"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#bloques').DataTable({
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
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }
            } );

            // Order by the grouping
            $('#bloques tbody').on( 'click', 'tr.group', function () {
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
   @if(session('warning'))
    <script type="text/javascript">
        toastr.warning("{{session('warning')}}")
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
