@extends('adminlte::page')

@section('title', 'Residentes')

@section('plugins.Toastr', 'true')

@section('content_header')
	<h1 class="ml-3">Unidades / Residentes / Vehiculos</h1>
@stop

@section('content')
	@livewire('admin.residentes-index')
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
