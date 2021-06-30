@extends('adminlte::page')

@section('title', 'Roles')

@section('plugins.Toastr', 'true')

@section('content_header')

@stop

@section('content')
	{!! Form::model($role, ['route'=>['admin.roles.update', $role], 'method'=>'put']) !!}	
	<div class="card card-primary">
	    <div class="card-header bg-primary">
			<h1 class="card-title">EDITAR ROL</h1>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
	    	@include('admin.role.partial.form')
	    </div>
		<!-- /.card-body -->
		<div class="card-footer">
			<div class="row">
				<div class="col-8 col-sm-10"><a href="{{route('admin.roles.index')}}">Volver al listado de Roles</a></div>
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
@stop