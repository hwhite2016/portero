@extends('adminlte::page')

@section('title', 'Usuarios')

@section('plugins.Toastr', 'true')
@section('plugins.Select2', 'true')

@section('content_header')

	{{-- <h1 class="ml-3">Asignar un rol</h1> --}}
@stop

@section('content')
<div class="card card-primary">
	<div class="card-header bg-primary">
		<h1 class="card-title">EDITAR USUARIO</h1>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		{!! Form::model($user, ['route'=>['admin.users.update', $user], 'method'=>'put']) !!}
		<div class="form-group  col-12 col-sm-8">
			<label>Nombre</label>
			<p class="form-control"> {{$user->name}} </p>
		</div>
		@include('admin.user.partial.form')
	</div>
	<!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.users.index')}}">Volver al listado de Usuarios</a></div>
            <div class="col-2 col-sm-1">
                {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
            </div>
            <div class="col-2 col-sm-1">
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    <!-- /.card-footer -->
	{!! Form::close() !!}
</div>
<!-- /.card -->
@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')
	<script>
		$(function () {
    		$('.select2').select2()
		})
	</script>
	@if(session('info'))
		<script type="text/javascript">
			toastr.success("{{session('info')}}")
		</script>
	@endif
@stop
