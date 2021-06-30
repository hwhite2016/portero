@extends('adminlte::page')

@section('title', 'Condominios')

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

              @can('admin.condominios.create')
              <div class="card-header">
                <h3 class="card-title">
                  <a href="{{route('admin.condominios.index')}}"> Listar todos los condominios</a>
                </h3>
                <a href="{{route('admin.condominios.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Conjunto</a>
              </div>
              <!-- /.card-header -->
              @endcan

              <div class="card-body">
                <table id="conjuntos" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>Logo</th>
                      <th>Barrio</th>
                      <th>Conjunto</th>
                      <th>Direccion</th>
                      <th>Correo</th>
                      <th>Celular</th>
                      <th>Estado</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($conjuntos as $conjunto)
                      <tr>
                        <td><img width="70px" src="/storage/{{ $conjunto->conjuntologo }}"> </td>
                        <td><label class="text-uppercase fw-bold"> {{ $conjunto->barrionombre }} </label>
                            <small> ({{ $conjunto->ciudadnombre }}) </small>
                        </td>
                        <td> {{ $conjunto->conjuntonombre }} </td>
                        <td> {{ $conjunto->conjuntodireccion }} </td>
                        <td> {{ $conjunto->conjuntocorreo }} </td>
                        <td> {{ $conjunto->conjuntocelular }} </td>
                        <td align="center">
                          <span class="badge {{$conjunto->conjuntoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$conjunto->conjuntoestado == 1 ? 'Activo' : 'Inactivo'}}</span>
                        </td>
                        <td>
                              @can('admin.condominios.destroy')
                              {!! Form::model($conjunto, ['route'=>['admin.condominios.destroy', $conjunto], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              @endcan

                              <a href="{{ route ('admin.bloques.show', $conjunto->id) }}" class="btn btn-warning btn-sm"  id="btn-bloque" data-toggle="tooltip" title="Ver Bloques"><i class="fas fa-th-large"></i> ({{ $conjunto->bloque_count }})</a>

                              @can('admin.condominios.edit')
                              <a href="{{route('admin.condominios.edit', $conjunto->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Conjunto">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              @endcan

                              @can('admin.condominios.destroy')
                              @csrf
                              {{-- @method('DELETE') --}}
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Conjunto"><i class="far fa-trash-alt"></i></button>

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
            var table = $('#conjuntos').DataTable({
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

             // Order by the grouping
            $('#conjuntos tbody').on( 'click', 'tr.group', function () {
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
