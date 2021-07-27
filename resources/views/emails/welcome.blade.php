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

    <h1>Estimado {{$contacto['name']}},</h1>
    @if($contacto['role_id'] == 3)
        <p>Reciba un cordial saludo.</p>
    @else
        <p>Recibe un cordial saludo por parte de la Administración. ¡Ahora eres parte de nuestra familia!</p>
    @endif

    @if($contacto['role_id'] == 3)
        <p>Su cuenta como administrador ha sido creada, y ahora usted puede iniciar sesion con las siguientes credenciales:</p>
    @else
        <p>Tu cuenta como residente ha sido creada, y ahora puedes iniciar sesion con las siguientes credenciales:</p>
    @endif


    <p><strong>Plataforma WEB: </strong>https://www.portero.com.co</p>
    <p><strong>Usuario: </strong>{{$contacto['email']}}</p>
    <p><strong>Contraseña: </strong>{{$contacto['password']}}</p>

    <p>Tendras acceso a los siguientes modulos:</p>
    @if($contacto['role_id'] == 3)
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

    @endif

</body>
</html>
