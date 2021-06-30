@extends('adminlte::page')

@section('title', 'Personas')

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
                  <a href="{{route('admin.personas.index')}}"> Listar todas las personas</a>
                </h3>
                @can('admin.personas.create')
                <a href="{{route('admin.personas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Persona</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="personas" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Documento</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Celular</th>
                      <th>Copropiedad</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($personas as $persona)
                      <tr>
                        <td> {{ $persona->personadocumento }} </td>
                        <td> {{ $persona->personanombre }} </td>
                        <td> {{ $persona->personacorreo }} </td>
                        <td> {{ $persona->personacelular }} </td>

                        <td>
                            @foreach ($persona->conjuntos as $conjunto)
                                <span class="badge bg-info">{{$conjunto->conjuntonombre}}</span>
                            @endforeach
                        </td>

                        <td>
                            @can('admin.personas.destroy')
                              {!! Form::model($persona, ['route'=>['admin.personas.destroy', $persona], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                            @endcan

                            @can('admin.personas.edit')
                              <a href="{{route('admin.personas.edit', $persona->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Persona">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                            @endcan

                            @can('admin.personas.destroy')
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Persona"><i class="far fa-trash-alt"></i></button>
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
            var table = $('#personas').DataTable({
                responsive: true
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
