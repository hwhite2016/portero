@extends('adminlte::page')

@section('title', 'Residentes')

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
                {{-- @can('admin.residentes.create')
                <a href="{{route('admin.residentes.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Residente</a>
                @endcan --}}

                @can('admin.residentes.create')
                {!! Form::open(['route'=>'admin.residentes.create', 'method'=>'get']) !!}
                @if (isset($id))
                    {!! Form::hidden('unidadid', $id) !!}
                @endif
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Residente</button>
                {!! Form::close() !!}
                @endcan



                <a class="btn btn-warning float-right mr-2" data-toggle="tooltip" title="Ver unidades" href="{{route('admin.unidads.index')}}"><i class="fas fa-angle-double-left"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="residentes" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-light">
                    <tr>
                      <th>Nombre</th>
                      <th>Unidad</th>
                      <th>Tipo</th>
                      <th>Relacion</th>
                      <th>Celular</th>
                      <th>Correo</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($residentes as $residente)
                      <tr>
                        <td>
                             {{ $residente->personanombre }}
                        </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $residente->unidadnombre }} </label>
                          <small> ({{ $residente->bloquenombre }}) </small>
                        </td>
                        <td> {{ $residente->tiporesidentenombre }} </td>
                        <td> {{ $residente->relationname }} </td>
                        <td> {{ $residente->personacelular }} </td>
                        <td>
                            @if($residente->personacorreo)
                                @if($residente->email)
                                    <span class="text-muted" data-toggle="tooltip" title="Usuario con acceso"><i class="fas fa-key mr-1"></i></span>
                                @else
                                    <span class="text-muted" data-toggle="tooltip" title="Usuario SIN de acceso"><i class="fas fa-ban mr-1"></i></span>
                                @endif
                            @endif
                            {{ $residente->personacorreo }}
                        </td>


                        <td>
                            @can('admin.residentes.destroy')
                              {!! Form::model($residente, ['route'=>['admin.residentes.destroy', $residente], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan

                              @can('admin.residentes.edit')
                              <a href="{{route('admin.residentes.edit', $residente->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Residente">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @endcan

                              @can('admin.residentes.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Residente"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#residentes').DataTable({
                lengthChange: false,
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'Residentes'
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
                .appendTo( '#residentes_wrapper .col-md-6:eq(0)' );


            // Order by the grouping
            $('#residentes tbody').on( 'click', 'tr.group', function () {
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
