@extends('adminlte::page')

@section('title', 'Empleados')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">
                    {{-- <a href="{{route('admin.index')}}"><i class="fas fa-house-user"></i> Ir al Home</a> --}}
                </h3>
                @can('admin.empleados.create')
                <a href="{{route('admin.empleados.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Colaborador</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="empleados" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-light">
                    <tr>
                      <th># Documento</th>
                      <th>Organo</th>
                      <th>Nombre</th>
                      <th>Cargo</th>
                      <th>Celular</th>
                      <th>Correo</th>
                      <th>Estado</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($empleados as $empleado)
                      <tr>
                        <td> {{ $empleado->personadocumento }} </td>
                        <td>
                          <label class="text-uppercase fw-bold"> {{ $empleado->organonombre }} </label>
                        </td>
                        <td> {{ $empleado->personanombre }} </td>
                        <td> {{ $empleado->cargonombre }}
                            @if($empleado->name) <br> <small><u><b>Rol:</b> {{ $empleado->name }}</u></small> @endif
                        </td>
                        <td> {{ $empleado->personacelular }} </td>
                        <td> {{ $empleado->personacorreo }} </td>
                        <td class="text-center">
                            <span class="badge {{$empleado->empleadoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$empleado->empleadoestado == 1 ? 'Activo' : 'Inactivo'}}</span>
                          </td>
                        <td>

                            @can('admin.empleados.destroy')
                            {!! Form::model($empleado, ['route'=>['admin.empleados.destroy', $empleado], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                            @endcan

                            @can('admin.empleados.edit')
                                @if(Auth::user()->hasRole('_consejero'))
                                    @if($empleado->cargonivel > 0)
                                        <a href="{{route('admin.empleados.edit', $empleado->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Empleado">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endif
                                @elseif(Auth::user()->hasRole('_administrador'))
                                    @if($empleado->cargonivel > 1)
                                        <a href="{{route('admin.empleados.edit', $empleado->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Empleado">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endif
                                @elseif(Auth::user()->hasRole('_superadministrador'))
                                    <a href="{{route('admin.empleados.edit', $empleado->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Empleado">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                            @endcan

                            @can('admin.empleados.destroy')
                            @csrf
                                @if(Auth::user()->hasRole('_consejero'))
                                    @if($empleado->cargonivel > 0)
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Empleado"><i class="far fa-trash-alt"></i></button>
                                        {!! Form::close() !!}
                                    @endif
                                @elseif(Auth::user()->hasRole('_administrador'))
                                    @if($empleado->cargonivel > 1)
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Empleado"><i class="far fa-trash-alt"></i></button>
                                        {!! Form::close() !!}
                                    @endif
                                @elseif(Auth::user()->hasRole('_superadministrador'))
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Empleado"><i class="far fa-trash-alt"></i></button>
                                    {!! Form::close() !!}
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
            var table = $('#empleados').DataTable({
                lengthChange: false,
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'EMPLEADOS'
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
                                '<tr class="group"><td colspan="7">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }

            } );

            table.buttons().container()
                .appendTo( '#empleados_wrapper .col-md-6:eq(0)' );


            // Order by the grouping
            $('#empleados tbody').on( 'click', 'tr.group', function () {
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
