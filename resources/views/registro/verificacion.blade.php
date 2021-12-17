@extends('adminlte::page_error')

@section('title', 'Registro')

@section('plugins.Sweetalert2', 'true')

@section('content_header')
    <div class='alert alert-default-primary alert-dismissible fade show' role='alert'>
        <i class="fas fa-info-circle"></i>&nbsp;
        Estimado usuario, usted ha completado el formulario, el cual sera validado por la administracion de su conjunto. Tan pronto se haga la validacion se le notificara a través de su correo electrónico.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
@stop

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <h1 class="card-title"><i class="fas fa-laptop-house"></i> <label>Módulos para el residente</label></h1>
    </div>
    <div class="card-body">
        <li>Programación y reporte de Visitantes</li>
        <li>Notificación de Correspondencia y/o Paqueteria</li>
        <li>Reserva de Zonas Comunes</li>
        <li>Comunicados (Email - Telegram)</li>
        <li>Documentos en linea</li>
        <li>Estructura Orgánica</li>
        <li>Sistema de PQRS (Peticiones, Quejas, Reclamos y Sugerencias)</li>
        <li><s>Pago Cuota de Administración</s></li>
        <li><s>Cartera</s></li>

    </div>
</div>

@stop

@section('js')
    @if(session('info'))
        <script type="text/javascript">
            Swal.fire(
                'Registro completado',
                'Estimado residente, tan pronto la informacion sea validada por la administracion, se le notificara a su correo electrónico',
                'success'
            )
    </script>
    @endif

@stop
