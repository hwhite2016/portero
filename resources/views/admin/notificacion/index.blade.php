@extends('adminlte::page')

@section('title', 'Notificaciones')

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
                    <span class="text text-primary">
                        <i class="far fa-envelope-open"></i> Notificaciones
                    </span>
                    <span class="count_notifications"></span>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(Auth::user())
                    @forelse ($notificaciones as $notification)

                        <div class="alert alert-default-{{$color}} alert-dismissible fade show" role="alert">
                            <button type="submit" class="float-right mark-as-read btn btn-outline btn-sm" data-toggle="tooltip" title="Marcar como leida" data-id="{{$notification->id}}">
                                <i class="far fa-envelope-open"></i>
                            </button>

                            <i class="{{$notification->data['icono']}}"></i>
                            <strong>{{$notification->data['title']}}</strong>
                            <small class="ml-1">({{$notification->created_at->diffForHumans()}})</small>
                            <p class="mb-0">Recibido por: {{$notification->data['entregareceptor']}}</p>
                            <p class="mb-0">Para: {{$notification->data['entregadestinatario']}}</p>
                            <p class="mb-0">{{$notification->data['descripcion']}}</p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>


                        </div>
                        @if ($loop->last)
                            <a href="#" id="mark-all">Marcar todas como leidas</a>

                        @endif

                    @empty
                        No hay notificaciones
                    @endforelse
                @endif
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

@stop

@section('js')

   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif
   <script>
       function sendMarkRequest(id=null) {
          return $.ajax("{{route('markNotificacion')}}", {
              method: 'POST',
              data: {
                  _token: "{{csrf_token()}}",
                  id
              }
          });
       }
       $(function(){
           $('[data-toggle="tooltip"]').tooltip();

           $('.mark-as-read').click(function(){
               let request = sendMarkRequest($(this).data('id'));

               request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
           });

           $('#mark-all').click(function(){
               let request = sendMarkRequest();

               request.done(()=>{
                   $('div.alert').remove();
               });
           });


       })
   </script>
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
