@extends('adminlte::page')

@section('title', 'Usuarios')

@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')
	<h1 class="ml-3">Lista de Usuarios</h1>
@stop

@section('content')
	@livewire('admin.users-index')
	{{-- <livewire:admin.users-index /> --}}
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
			  title: 'Esta seguro de eliminar este registro?',
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
