@extends('adminlte::page')

@section('title', 'Parqueaderos')

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
                  <a href="{{route('admin.parqueaderos.index')}}"> Listar todos los parqueaderos</a>
                </h3>

                <a href="{{route('admin.parqueaderos.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Parqueadero</a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="parqueaderos" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Parqueadero</th>
                      <th>Conjunto</th>
                      <th>Piso</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($parqueaderos as $parqueadero)
                      <tr>
                        <td> {{ $parqueadero->parqueaderonumero }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $parqueadero->conjuntonombre }} </label>
                          <small> ({{ $parqueadero->barrionombre }}) </small>
                        </td>
                        <td> {{ $parqueadero->parqueaderopiso }} </td>
                        <td> {{ $parqueadero->parqueaderotipo }} </td>
                        <td align="center">
                            <span class="badge {{$parqueadero->parqueaderoestado == 1 ? 'bg-danger' : 'bg-success'}}">{{$parqueadero->parqueaderoestado == 1 ? 'Ocupado' : 'Disponible'}}</span>
                        </td>
                         <td>
                            @can('admin.parqueaderos.destroy')
                              {!! Form::model($parqueadero, ['route'=>['admin.parqueaderos.destroy', $parqueadero], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan

                              @can('admin.parqueaderos.edit')
                              <a href="{{route('admin.parqueaderos.edit', $parqueadero->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Parqueadero">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @endcan

                              @can('admin.parqueaderos.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Parqueadero"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#parqueaderos').DataTable({
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
            $('#parqueaderos tbody').on( 'click', 'tr.group', function () {
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