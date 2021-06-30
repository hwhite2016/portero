@extends('adminlte::page')

@section('title', 'Usuarios')

@section('plugins.Toastr', 'true')
@section('plugins.Select2', 'true')

@section('content_header')

	{{-- <h1 class="ml-3">Crear Usuario</h1> --}}
@stop

@section('content')
<div class="card">
	<div class="card-body">

		{!! Form::open(['route'=>'admin.users.store']) !!}

		<div class="card card-primary">
			<div class="card-header bg-primary">
				<h1 class="card-title">CREAR NUEVO USUARIO</h1>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="container-fluid">
				<div class="row">
					<div class="form-group col-md-4">
					{{ Form::label('email', 'Dirección de E-mail') }}
					{{ Form::text('email', null, array('placeholder' => 'Introduce tu E-mail', 'class' => 'form-control')) }}
					@error('email')
						<small class="text-danger">
							{{$message}}
						</small>
					@enderror
					</div>
					<div class="form-group col-md-4">
					{{ Form::label('name', 'Nombre completo') }}
					{{ Form::text('name', null, array('placeholder' => 'Introduce tu nombre y apellido', 'class' => 'form-control')) }}
					@error('name')
						<small class="text-danger">
							{{$message}}
						</small>
					@enderror
					</div>
					<div class="form-group col-md-4">
					{{ Form::label('password', 'Contraseña') }}
					{{ Form::password('password', array('class' => 'form-control')) }}
					@error('password')
						<small class="text-danger">
							{{$message}}
						</small>
					@enderror
					</div>

				</div>
				</div>
			</div>
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
