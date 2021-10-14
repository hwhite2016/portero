@extends('adminlte::page')

@section('title', 'Normativas y Reglamentos')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h1 class="card-title text-primary">
            <label>Documentos</label>
        </h1>
        @can('admin.normas.create')
        <a href="{{route('admin.normas.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Documento</a>
        @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">


            @if(!$normas->count())
                <div class="col-12">
                    <div class='alert alert-default-warning' role='alert'>
                        <i class='fas fa-exclamation-triangle'></i>
                        &nbsp; Aun no existen documentos.
                    </div>
                </div>
            @endif
            @foreach ($normas as $norma)

                <div class="card card-light">
                    <div class="card-header">
                        <h1 class="card-title">
                            <label>{{ $norma->tiponormanombre }}</label> ( <small class="font-italic">{{ strftime("%d de %B de %Y", strtotime($norma->created_at)) }}</small> )
                        </h1>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(($norma->ruta) && ($norma->adjunto))
                            <a href="{{ $norma->ruta }}" target="_blank" class="text-primary ml-2"><i class="fas fa-caret-right"></i> <u>{{ $norma->normanombre }}</u></a>
                            <a href="/storage/{{ $norma->conjuntoid }}/documentos/{{ $norma->adjunto }}" target="_blank" class="text-primary ml-2"> ( Descargar <i class="fas fa-download"></i> )</a>
                        @elseif($norma->ruta)
                            <a href="{{ $norma->ruta }}" target="_blank" class="text-primary ml-2"><i class="fas fa-caret-right"></i> <u>{{ $norma->normanombre }}</u></a>
                        @elseif($norma->adjunto)
                            <span class="ml-2"><i class="fas fa-caret-right"></i> {{ $norma->normanombre }}</span>
                            <a href="/storage/{{ $norma->conjuntoid }}/documentos/{{ $norma->adjunto }}" target="_blank" class="text-primary ml-2"> ( Descargar <i class="fas fa-download"></i> )</a>
                        @else
                            <span class="ml-2"><i class="fas fa-caret-right"></i> {{ $norma->normanombre }}</span>
                        @endif
                    </div>

                    @can('admin.normas.edit')
                    <div class="card-footer">
                        @can('admin.normas.destroy')
                            {!! Form::model($norma, ['route'=>['admin.normas.destroy', $norma], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                            @csrf
                        @endcan

                        @can('admin.normas.edit')
                        <a href="{{route('admin.normas.edit', $norma->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Documento">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @endcan

                        @can('admin.normas.destroy')
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Documento"><i class="far fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                        @endcan
                    </div>
                    @endcan
                </div>



            {{-- <div class="row mb-2">
                    <div class="col-1">
                        @can('admin.normas.destroy')
                            {!! Form::model($norma, ['route'=>['admin.normas.destroy', $norma], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                            @csrf
                        @endcan

                        @can('admin.normas.edit')
                        <a href="{{route('admin.normas.edit', $norma->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Documento">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @endcan

                        @can('admin.normas.destroy')
                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Documento"><i class="far fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                        @endcan
                    </div>
                    <div class="col-11">
                        <div class="row">
                            <div class="col-2">
                                <b>| {{ $norma->tiponormanombre }} |</b><br>
                                <small class="font-italic ml-2">{{ strftime("%d de %B de %Y")}}</small>
                            </div>
                            <div class="col-10">
                                @if(($norma->ruta) && ($norma->adjunto))
                                    <a href="{{ $norma->ruta }}" target="_blank" class="text-primary ml-2"><i class="fas fa-caret-right"></i> <u>{{ $norma->normanombre }}</u></a>
                                    <a href="/storage/{{ $norma->conjuntoid }}/documentos/{{ $norma->adjunto }}" target="_blank" class="text-primary ml-2"> ( Descargar <i class="fas fa-download"></i> )</a>
                                @elseif($norma->ruta)
                                    <a href="{{ $norma->ruta }}" target="_blank" class="text-primary ml-2"><i class="fas fa-caret-right"></i> <u>{{ $norma->normanombre }}</u></a>
                                @elseif($norma->adjunto)
                                    <span class="ml-2"><i class="fas fa-caret-right"></i> {{ $norma->normanombre }}</span>
                                    <a href="/storage/{{ $norma->conjuntoid }}/documentos/{{ $norma->adjunto }}" target="_blank" class="text-primary ml-2"> ( Descargar <i class="fas fa-download"></i> )</a>
                                @else
                                    <span class="ml-2"><i class="fas fa-caret-right"></i> {{ $norma->normanombre }}</span>
                                @endif
                            </div>

                        </div>
                    </div>

                </div> --}}

            @endforeach

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
