@extends('adminlte::page')

@section('title', 'Paises')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="{{route('admin.pais.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Pais</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pais" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Bandera</th>
                      <th>Pais</th>
                      <th>Codigo</th>
                      <th>Abreviatura</th>
                      <th width="5%">...</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($paises as $pais)
                      <tr>
                        <td><img width="40px" src="/storage/{{ $pais->paisbandera }}" alt="image"></td>
                        <td> {{ $pais->paisnombre }} </td>
                        <td> {{ $pais->paiscodigo }} </td>
                        <td> {{ $pais->paisabreviatura }} </td>

                        <td>

                            <form action="{{ route ('admin.pais.destroy', $pais->id) }}" method="POST" class="frm_delete">

                            <a href="{{ route ('admin.ciudads.show', $pais->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ver Ciudades"><i class="fas fa-city"></i> ({{ $pais->city_count }})</a>

                            <a href="{{route('admin.pais.edit', $pais->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar pais">
                              <i class="fas fa-pencil-alt"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Pais"><i class="far fa-trash-alt"></i></button>
                          </form>
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
</div>
<!-- ./wrapper -->
@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')


    <script type="text/javascript">

        $(document).ready(function() {
          var table = $('#pais').DataTable( {
              responsive: true
          } );

          new $.fn.dataTable.FixedHeader( table );

          $('[data-toggle="tooltip"]').tooltip();

        });
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

  </script>@stop
