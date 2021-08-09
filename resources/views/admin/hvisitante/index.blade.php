@extends('adminlte::page')

@section('title', 'Visitantes')

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
                {{-- <h3 class="card-title">
                    <a href="{{route('admin.visitantes.index')}}"> Visitantes activos</a>
                </h3> --}}
                <a class="btn btn-success float-right mr-2" href="{{route('admin.visitantes.index')}}"><i class="fas fa-check"></i> Visitantes Activos</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="visitantes" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Unidad</th>
                      <th>Conjunto</th>
                      <th>Parqueadero / Placa</th>
                      <th>Documento</th>
                      <th>Nombre</th>
                      <th>Celular</th>
                      <th>Hora ingreso</th>
                      <th>Hora Salida</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($visitantes as $visitante)
                      <tr>
                        <td> {{ $visitante->unidadnombre }} </td>
                        <td> {{ $visitante->conjuntonombre }} </td>
                        <td> {{ $visitante->parqueadero .' / '. $visitante->visitanteplaca}} </td>
                        <td> {{ $visitante->documento }} </td>
                        <td> {{ $visitante->personanombre }} </td>
                        <td> {{ $visitante->personacelular }} </td>
                        <td> {{ $visitante->visitanteingreso }} </td>
                        <td> {{ $visitante->visitantesalida }} </td>

                        <td>

                            @can('admin.visitantes.hdestroy')
                              {!! Form::model($visitante, ['route'=>['admin.visitantes.hdestroy', $visitante], 'method'=>'head', 'class'=>'frm_delete']) !!}
                            @endcan

                            @can('admin.visitantes.restaurar')
                              <a href="{{route('admin.visitantes.restaurar', $visitante->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Restaurar Visitante">
                                  <i class="fas fa-undo"></i>
                              </a>
                            @endcan

                            @can('admin.visitantes.hdestroy')
                              @csrf
                              @method('head')
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Visitante"><i class="fas fa-trash"></i></button>
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
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->

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
        var table = $('#visitantes').DataTable({
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
        $('#visitantes tbody').on( 'click', 'tr.group', function () {
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
            title: 'Se dispone a eliminar el visitante',
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
