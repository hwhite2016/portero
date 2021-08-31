<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h4{
            color:rgb(5, 55, 112);
        }
    </style>

</head>
<body>

    <h1>Estimado(a) {{$contacto['name']}},</h1>
    @if($contacto['role_id'] != 5)
        <p>Reciba un cordial saludo.</p>
    @else
        <p>Recibe un cordial saludo por parte de la Administración. ¡Ahora eres parte de nuestra familia!</p>
    @endif

    @if($contacto['role_id'] != 5)
        <p>Su cuenta como colaborador del conjunto ha sido creada, y ahora usted puede iniciar sesion con las siguientes credenciales:</p>
    @else
        <p>Su cuenta como residente ha sido creada, y ahora puede iniciar sesion con las siguientes credenciales:</p>
    @endif


    <p><strong>Aplicación Web: </strong>https://www.portero.com.co/admin</p>
    <p><strong>Usuario: </strong>{{$contacto['email']}}</p>
    <p><strong>Contraseña: </strong>{{$contacto['password']}}</p>

    <p>Tendras acceso a los siguientes modulos:</p>
    @if($contacto['role_id'] != 5)
        <p>Configuracion Propiedad Horizontal:</p>
        <ol>
            <li>Gestión de la Propiedad Horizontal (Paerqueaderos, Unidades, Residentes, Zonas Comunes, etc..</li>
            <li>Gestión de Visitantes</li>
            <li>Asignación de Parqueaderos para Visitantes</li>
            <li>Control de Acceso Peatonal</li>
            <li>Control de Acceso Vehicular</li>
            <li>Gestión de Correspondencia y/o Paqueteria</li>
            <li>Servicio de Notificaciones</li>
            <li>Sistema de PQRS</li>
            <li>Recaudo Cuota de Administración</li>
        </ol>

        <p>Si tiene preguntas, por favor coloquese en contacto al siguiente correo: support@portero.com.co</p>

    @else
        <p>Opciones disponibles en su Plan:</p>
        <ol>
            <li>Gestión de Visitantes</li>
            <li>Gestión de Correspondencia y/o Paqueteria</li>
            <li>Reserva de Zonas Comunes</li>
            <li>Sistema de PQRS (Peticiones, Quejas, Reclamos y Sugerencias)</li>
            <li>Pago de la Cuota de Administración</li>
        </ol>

        <p>Si tiene preguntas, por favor coloquese en contacto con la administración del conjunto</p>

    @endif

</body>
</html>
