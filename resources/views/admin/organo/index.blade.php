@extends('adminlte::page')

@section('title', 'Organos')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Organos de Control</label>
        </h1>
        @can('admin.organos.create')
            <a href="{{route('admin.organos.create')}}" class="btn btn-primary ml-2 float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Organo</a>
        @endcan

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            @foreach ($organos as $organo)
                <div class="col-12 col-md-4">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <label class="card-title">{{ $organo->organonombre }}</label>

                            <small class="text-muted float-right">
                                <a href="{{route('admin.empleados.show', $organo->id)}}">Miembros [<b>{{ $organo->emp_count }}</b>]</a>
                            </small>

                        </div>
                        <div class="card-body">
                            <span class="text-muted"><i class="far fa-envelope"></i> {{ $organo->organocorreo }}</span><br>
                            <span class="text-muted"><i class="fas fa-mobile-alt"></i> {{ $organo->organocelular }}</span><br>
                            <span class="text-muted"><i class="fas fa-phone-volume"></i> {{ $organo->organotelefono }}</span>

                            <div class="row">
                                <div class="col-12">

                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                            @can('admin.organos.edit')
                                <a href="{{route('admin.organos.edit', $organo->id)}}" class="btn btn-sm btn-default  float-right mr-2" data-toggle="tooltip" title="Editar organo">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endcan

                            @can('admin.organos.destroy')
                                {!! Form::model($organo, ['route'=>['admin.organos.destroy', $organo], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                @csrf
                                {{-- @method('DELETE') --}}
                                <button class="btn btn-sm btn-default float-right mr-2" data-toggle="tooltip" title="Eliminar organo"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}
                            @endcan

                            <span class="badge {{$organo->organopqr == 1 ? 'bg-secondary' : ''}}">{{$organo->organopqr == 1 ? 'Agente PQR' : ''}}</span>
                            <span class="badge {{$organo->organoestado == 1 ? 'bg-success' : 'bg-danger'}}">{{$organo->organoestado == 1 ? 'Visible' : 'Oculto'}}</span>
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
