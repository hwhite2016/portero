@extends('adminlte::page')

@section('title', 'Pqrs')

@section('plugins.Datatables', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')



    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card  mt-3">
              <div class="card-header">
                @can('admin.pqrs.create')

                <div class="row">
                    <div class="col-md-2" onclick="location.href='{{route('admin.pqrs.show', 1)}}'" style="cursor:pointer">
                        <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-secondary"><i class="far fa-envelope-open"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Abiertas</span>
                            <span class="info-box-number">{{$pqr_abierta}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2" onclick="location.href='{{route('admin.pqrs.show', 2)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-warning"><i class="fas fa-sync-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">En tramite</span>
                            <span class="info-box-number">{{$pqr_proceso}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2" onclick="location.href='{{route('admin.pqrs.show', 3)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-info"><i class="far fa-calendar-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Resueltas</span>
                            <span class="info-box-number">{{$pqr_resuelta}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2" onclick="location.href='{{route('admin.pqrs.show', 4)}}'" style="cursor:pointer">
                        <div class="info-box info-box shadow-lg">
                        <span class="info-box-icon bg-success"><i class="far fa-envelope"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Cerradas</span>
                            <span class="info-box-number">{{$pqr_cerrada}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->


                    <div class="col-md-4">
                        <a href="{{route('admin.pqrs.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Ticket</a>
                    </div>
                </div>
                <!-- /.row -->
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pqrs" class="table table-striped table-bordered table-hover table-sm nowrap" style="width:100%">
                  <thead class="bg-primary">
                    <tr>
                      <th>Radicado</th>
                      <th>Tipo</th>
                      <th>Asunto</th>

                      <th width="5%">...</th>


                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pqrs as $pqr)
                      <tr>
                        <td> TK-{{ str_pad($pqr->radicado,5,"0", STR_PAD_LEFT) }} </td>
                        <td> {{ $pqr->tipopqrnombre }} </td>
                        <td>
                            <a href="{{route('admin.pqrs.edit', $pqr->id)}}"> {{ $pqr->asunto}} </a>
                            <br><small>Fecha: {{ $pqr->created_at }}</small>
                        </td>

                        <td>

                            @can('admin.pqrs.destroy')
                              {!! Form::model($pqr, ['route'=>['admin.pqrs.destroy', $pqr], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                              {!! Form::hidden('estadoid', $pqr->estadoid, array('class' => 'estadoid')) !!}
                              {!! Form::hidden('motivo', null, array('class' => 'motivo')) !!}
                            @endcan

                            {{-- @can('admin.pqrs.edit')
                              <a href="{{route('admin.pqrs.edit', $pqr->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Pqr">
                                <i class="fas fa-eye"></i>
                              </a>
                            @endcan --}}

                            @can('admin.pqrs.destroy')
                              @csrf
                              @method('delete')
                              <button class="btn btn-sm btn-{{ in_array($pqr->estadoid, [1,2,3])?'success':'danger' }}">{{ in_array($pqr->estadoid, [1,2,3])?'Cerrar':'Abrir' }} Ticket</button>
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

<link rel="stylesheet" type="text/css" href="/css/addtohomescreen.css">

@stop

@section('js')


<script src="/js/addtohomescreen.js"></script>
<script>
addToHomescreen();
</script>

<script type="text/javascript">

        $(document).ready(function() {
            var groupColumn = 1;
            var table = $('#pqrs').DataTable({
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
            $('#pqrs tbody').on( 'click', 'tr.group', function () {
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
          if($('.estadoid').val() == 1){

            url = "{{ route('admin.pqrs.motivo') }}";
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    console.log(data.motivo);
                    var myArr = data.motivo.motivo;
                },
                error: function(error){
                    console.log(error);
                }
            });

            var myArr = [ '1', '2', '3'];
            const { value: motivo } = Swal.fire({
                title: 'Motivo del cierre del Ticket?',
                input: 'select',
                //inputOptions: myArr,
                inputOptions: {
                    '1': 'Cree el ticket por error',
                    '2': 'Encontre una solución por mi mismo',
                    '3': 'Solicitud no valida'
                },
                inputPlaceholder: 'Motivo de cierre',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (myArr.includes( value )) {
                            //resolve()
                            $('.motivo').val(value)
                            this.submit()
                        } else {
                            resolve('Seleccione una opcion valida')
                        }
                    })
                }
            })

          }else{

                Swal.fire({
                    title: 'Esta a punto de re-abrir el ticket.',
                    text: 'Tenga en cuenta que los estados seran reiniciados.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Abrir Ticket!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                    this.submit();
                    }
                })

          }

      });

   </script>
@stop
