@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')


<!-- Main content -->
<section class="content">
    <div class="container-fluid">

      <!-- Timelime example  -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <div class="timeline">


            <!-- timeline time label -->
            <div class="time-label mt-4">
              <span class="bg-{{$color}}"><i class="far fa-bell"></i> Notificaciones</span>
            </div>
            <!-- /.timeline-label -->

            @if(Auth::user())
                @forelse ($notificaciones as $notification)
                    <!-- timeline item -->
                    <div class="alert">
                        <i class="{{$notification->data['icono']}} bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{$notification->created_at->diffForHumans()}}</span>
                            <h3 class="timeline-header"><span class="text-primary font-weight-bold">{{$notification->data['title']}}:</span> {{$notification->data['body']}}</h3>

                            <div class="timeline-body">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p class="mb-0">{{$notification->data['empresa']}}</p>
                                <p class="mb-0">Recibido por: {{$notification->data['entregareceptor']}}</p>
                                <p class="mb-0">{{$notification->data['descripcion']}}</p>

                            </div>
                            @if($id == 0)
                                <div class="timeline-footer">
                                    <button type="submit" class="btn btn-primary btn-sm mark-as-read" title="Marcar como leida" data-id="{{$notification->id}}"><i class="far fa-envelope-open"></i> Marcar como leida</button>
                                </div>
                            @else
                                <div class="timeline-footer">
                                    <button type="submit" class="btn btn-success btn-sm mark-as-not-read" title="Marcar como no leida" data-id="{{$notification->id}}"><i class="far fa-envelope-open"></i> Marcar como no leida</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- END timeline item -->


                    @if ($loop->last)
                        @if($id == 0)
                            <div class="ml-4"><a href="#" id="mark-all" class="ml-4">Marcar todas como leidas</a></div>

                        @endif
                    @endif

                @empty
                    <div class="ml-4"><span class="ml-4">No hay notificaciones</span></div>
                @endforelse
            @endif


            <!-- timeline time label -->


            <div>
              <i class="fas fa-clock bg-gray"></i>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.timeline -->

  </section>
  <!-- /.content -->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

<style>
    .timeline>div>.timeline-item {
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    border-radius: .25rem;
    background-color: #fff;
    color: #495057;
    margin-left: 40px;
    margin-right: -30px;
    margin-top: 0;
    padding: 0;
    position: relative;
}
</style>

@stop

@section('js')

   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif
   <script>
       function sendMarkRequest(id=null, estado=null) {
          return $.ajax("{{route('markNotificacion')}}", {
              method: 'POST',
              data: {
                  _token: "{{csrf_token()}}",
                  id,
                  estado
              }
          });
       }
       $(function(){
           $('[data-toggle="tooltip"]').tooltip();

           $('.mark-as-read').click(function(){
               let request = sendMarkRequest($(this).data('id'), 0);

               request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
           });

           $('.mark-as-not-read').click(function(){
               let request = sendMarkRequest($(this).data('id'), 1);

               request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
           });

           $('#mark-all').click(function(){
               let request = sendMarkRequest(null, 0);

               request.done(()=>{
                   $('div.alert').remove();
               });
           });

           $('#mark-all-not').click(function(){
               let request = sendMarkRequest(null, 1);

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
