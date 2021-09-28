@extends('adminlte::page')

@section('title', 'Mascotas')

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
                @can('admin.mascotas.create')
                <a href="{{route('admin.mascotas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Mascota</a>
                @endcan
                <a class="btn btn-warning float-right mr-2" href="{{route('admin.unidads.index')}}"><i class="fas fa-arrow-left"></i> Unidades</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="mascotas" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-light">
                    <tr>
                      <th>Tipo</th>
                      <th>Unidad</th>
                      <th>Nombre</th>
                      <th>Raza</th>
                      <th>Edad (meses)</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mascotas as $mascota)
                      <tr>
                        <td> {{ $mascota->tipomascotanombre }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $mascota->unidadnombre }} </label>
                          <small> ({{ $mascota->bloquenombre }}) </small>
                        </td>
                        <td> {{ $mascota->mascotanombre }} </td>
                        <td> {{ $mascota->mascotaraza }} </td>
                        <td> {{ $mascota->mascotaedad }} </td>

                        <td>
                            @can('admin.mascotas.destroy')
                              {!! Form::model($mascota, ['route'=>['admin.mascotas.destroy', $mascota], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan

                              @can('admin.mascotas.edit')
                              <a href="{{route('admin.mascotas.edit', $mascota->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Mascota">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @endcan

                              @can('admin.mascotas.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Mascota"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#mascotas').DataTable({
                lengthChange: false,
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'Mascotas'
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
                                '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }

            } );

            table.buttons().container()
                .appendTo( '#mascotas_wrapper .col-md-6:eq(0)' );


            // Order by the grouping
            $('#mascotas tbody').on( 'click', 'tr.group', function () {
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
