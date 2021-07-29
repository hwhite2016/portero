@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')
<i class="far fa-bell"></i> Notificaciones
@stop

@section('content')

@php

    $vector = array();

	foreach ($notificaciones as $n){
        $fecha =  date("Ymd", strtotime($n->created_at));
        $vector[$fecha][$n->id] = $n->data;
        $vector[$fecha][$n->id]['created'] = $n->created_at;
        //$vector[$fecha]['created_at'][] = $n->created_at;
        //$vector[$fecha]['data'][] = $n->data;
    };

    //var_dump($vector);

    // foreach ($vector as $v1 => $k1){
    //     echo $v1 .": <br>";
    //     foreach ($k1 as $indice => $valor){
    //         echo $indice .": ".$valor['fecharecibo']."<br>";

    //     }
    // }

    function time_passed($get_timestamp)
{
        $timestamp = strtotime($get_timestamp);
        $diff = time() - (int)$timestamp;

        if ($diff == 0)
             return 'justo ahora';

        if ($diff > 604800)
            return date("d M Y",$timestamp);

        $intervals = array
        (
            //1                   => array('año',    31556926),
           // $diff < 31556926    => array('mes',   2628000),
           // $diff < 2629744     => array('semana',    604800),
            $diff < 604800      => array('día',     86400),
            $diff < 86400       => array('hora',    3600),
            $diff < 3600        => array('minuto',  60),
            $diff < 60          => array('segundo',  1)
        );

        $value = floor($diff/$intervals[1][1]);
        return 'hace '.$value.' '.$intervals[1][0].($value > 1 ? 's' : '');
}

@endphp





<!-- Main content -->
<section class="content">
    <div class="container-fluid">

      <!-- Timelime example  -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <div class="timeline">



            @if(Auth::user())


            @foreach ($vector as $v1 => $k1)
                <!-- timeline time label -->
                <div class="time-label">
                    <span class="bg-{{$color}}">{{date('Y/m/d', strtotime($v1))}}</span>
                </div>
                <!-- /.timeline-label -->

                @forelse ($k1 as $indice => $valor)

                <!-- timeline item -->
                {{-- ->diffForHumans() --}}

                    <div class="alert">
                        <i class="{{$valor['icono']}} bg-{{$color}}"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{time_passed($valor['fecharecibo'])}}</span>
                            <h3 class="timeline-header"><span class="text-primary font-weight-bold">{{$valor['title']}}:</span> {{$valor['body']}}</h3>

                            <div class="timeline-body">
                                <button type="button" class="close del" data-id="{{$indice}}" aria-label="Close" data-toggle="tooltip" title="Eliminar notificación">
                                    <span aria-hidden="true">&times;</span>
                                    {{-- data-dismiss="alert" --}}
                                </button>

                                <p class="mb-0">{{$valor['empresa']}}</p>
                                <p class="mb-0">Recibido por: {{$valor['entregareceptor']}}</p>
                                <p class="mb-0">{{$valor['descripcion']}}</p>

                            </div>
                            @if($id == 0)
                                <div class="timeline-footer">
                                    <button type="submit" class="btn btn-primary btn-sm mark-as-read" title="Marcar como leida" data-id="{{$indice}}"><i class="far fa-envelope-open"></i> Marcar como leida</button>
                                </div>
                            @else
                                <div class="timeline-footer">
                                    <button type="submit" class="btn btn-primary btn-sm mark-as-not-read" title="Marcar como no leida" data-id="{{$indice}}"><i class="far fa-envelope-open"></i> Marcar como no leida</button>
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

            @endforeach


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

    <link rel="stylesheet" type="text/css" href="/css/addtohomescreen.css">

@stop

@section('js')

    <script src="/js/addtohomescreen.min.js"></script>
    <script>
        addToHomescreen();
    </script>

   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif
   <script>
       function sendMarkRequest(id=null, estado=null, accion=null) {
          return $.ajax("{{route('markNotificacion')}}", {
              method: 'POST',
              data: {
                  _token: "{{csrf_token()}}",
                  id,
                  estado,
                  accion
              }
          });
       }

       $(function(){
           $('[data-toggle="tooltip"]').tooltip();

           $('.mark-as-read').click(function(){
               let request = sendMarkRequest($(this).data('id'), 0, 'mark');

               request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
           });

           $('.mark-as-not-read').click(function(){
               let request = sendMarkRequest($(this).data('id'), 1, 'mark');

               request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
           });

           $('#mark-all').click(function(){
               let request = sendMarkRequest(null, 0, 'mark');

               request.done(()=>{
                   $('div.alert').remove();
               });
           });

           $('#mark-all-not').click(function(){
               let request = sendMarkRequest(null, 1, 'mark');

               request.done(()=>{
                   $('div.alert').remove();
               });
           });


       })
   </script>

   <script>
      $('.del').click(function(e){
          e.preventDefault();

          Swal.fire({
            title: 'Realmente desea eliminar la notificación?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
                let request = sendMarkRequest($(this).data('id'), null, 'del');
                request.done(()=>{
                   $(this).parents('div.alert').remove();
               });
            }
          })
      });

   </script>
@stop
