@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Zonas Comunes</label>
        </h1>
        @can('admin.zonas.create')
            <a href="{{route('admin.zonas.create')}}" class="btn btn-primary ml-2 float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Zona</a>
        @endcan
        @can('admin.reservas.index')
            <a href="{{route('admin.reservas.index')}}" class="btn btn-primary float-right"><i class="far fa-calendar-check"></i> &nbsp Reservas</a>
        @endcan

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            @foreach ($zonas as $zona)
                <div class="col-12 col-md-3">
                    <div class="card shadow-lg">
                        <div style="background-image: url('/storage/{{ $zona->zonaimagen }}'); background-repeat: no-repeat;background-size: cover; min-height: 120px; width: 100%; background-position-y: 50%;"></div>
                        {{-- <img src="/storage/{{ $zona->zonaimagen }}" width="250px" class="card-img" alt="..."> --}}
                        <div class="card-body">
                            <span class="float-right badge {{intval(str_replace(':', '', $zona->zonahoraapertura)) < intval(date('Hm')) && intval(str_replace(':', '', $zona->zonahoracierre)) > intval(date('Hm')) ? 'bg-success' : 'bg-danger'}}">{{intval(str_replace(':', '', $zona->zonahoraapertura)) < intval(date('Hm')) && intval(str_replace(':', '', $zona->zonahoracierre)) > intval(date('Hm')) ? 'Abierto' : 'Cerrado'}}</span>
                            <small class="card-text text-muted">{{ $zona->conjuntonombre }}</small><br>
                            <label class="card-title">{{ $zona->zonanombre }}</label>
                            <p class="card-text">{{ $zona->zonadescripcion }}</p>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">
                                        {!! Form::checkbox('terminos[]', $zona->id, true, ['class'=>'mr-1 terminos']) !!}
                                        <a href="#" data-toggle="modal" data-target="#idModal" data-whatever="{{$zona->id}}">
                                            Terminos y condiciones de uso
                                        </a>
                                    </small>
                                </div>
                                {{--
                                <div class="col-6">
                                    <small class="text-muted"><i class="fas fa-mobile-alt"></i> {{ $zona->zonacelular }}</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted"><i class="fas fa-phone-volume"></i> {{ $zona->zonatelefono }}</small>
                                </div> --}}
                            </div>

                        </div>
                        <!-- /.card-body -->

                            <div class="card-footer">

                                <div class="row">
                                    @if (($zona->zonareservable == 1))
                                    <div class="col-7">
                                    @elseif(($zona->zonareservable == 0) and (($zona->zonaestado == 0) or ($zona->zonaestado == 2)))
                                    <div class="col-7">
                                    @else
                                    <div class="col-12">
                                    @endif

                                        @can('admin.zonas.edit')
                                            <a href="{{route('admin.zonas.edit', $zona->id)}}" class="btn btn-sm btn-default  float-right mr-2" data-toggle="tooltip" title="Editar zona">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- <a href="{{route('admin.zonas.edit', $zona->id)}}" class="btn btn-sm btn-default  float-right mr-2" data-toggle="tooltip" title="Editar zona">
                                                <span style="font-size: 1em; color: #7F8C8D;">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </span>
                                            </a> --}}

                                            @if($zona->zonareservable == 1)
                                            <a href="{{route('admin.zonas.calendario', $zona->id)}}" class="btn btn-sm btn-default float-right mr-2" data-toggle="tooltip" title="Editar Calendario" >
                                                <i class="fas fa-calendar-alt"></i>
                                            </a>
                                            @endif

                                        @endcan


                                        @can('admin.zonas.destroy')
                                            {!! Form::model($zona, ['route'=>['admin.zonas.destroy', $zona], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                            @csrf
                                            {{-- @method('DELETE') --}}
                                            <button class="btn btn-sm btn-default float-right mr-2" data-toggle="tooltip" title="Eliminar zona"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>

                                    @if ($zona->zonaestado == 0)
                                        <div class="col-5">
                                            <small class="font-italic text-danger">[ Deshabilitada ]</small>
                                        </div>
                                    @elseif ($zona->zonaestado == 2)
                                        <div class="col-5">
                                            <small class="font-italic text-danger">[ En mantenimiento ]</small>
                                        </div>
                                    @endcan
                                    @if (($zona->zonareservable == 1) and ($zona->zonaestado == 1))
                                        <div class="col-5">
                                            @can('admin.reservas.edit')
                                            {!! Form::open(['route'=>['admin.reservas.edit', $zona->id], 'method'=>'get']) !!}
                                            <button class="btn btn-block btn-outline-success btn-sm  float-right"  id="reservar_{{$zona->id}}">
                                                <i class="fas fa-sign-in-alt"></i> Reservar
                                            </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        </div>
                                    @endif


                                </div>

                            </div>
                            <!-- /.card-footer -->

                    </div>
                    <!-- /.card-->
                </div>
            @endforeach
        </div>
        <!-- /.row-->
    </div>
    <!-- /.card-body-->
</div>
<!-- /.card-->


<!-- Modal -->
<div class="modal fade" id="idModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-justify">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $(".terminos").on("click", function(){
                if(!$(this).is(":checked")){
                    $('#reservar_' + $(this).val()).attr('disabled', 'disabled');
                } else {
                    $('#reservar_'  + $(this).val()).removeAttr('disabled');
                }
            });

            $('#idModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('whatever')
                var modal = $(this)
                var url = "{{ route('admin.zonas.terminosModal', ":id") }}";
                url = url.replace(':id', id);


                $.ajax({
                    async: true,
                    url: url,
                    type: 'GET',
                    dataType: "json",
                    success: function (data) {
                        modal.find('.modal-title').text('Terminos y condiciones de uso')
                        modal.find('.modal-body').html(data.zonaterminos)
                    },
                    error: function (error) {
                        funError(error);
                    }
                })
            });

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
