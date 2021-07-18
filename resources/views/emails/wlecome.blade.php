<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h1{
            color:darkgreen;
        }
    </style>

</head>
<body>

    <h1>Estimado residente del Conjunto residencial siena,</h1>

    De parte de la Administración, Comité de Convivencia y Consejo de Administración Te damos la bienvenida e invitamos a que hagas parte
    de nuestra comunidad y seas miembro en la nueva aplicacion PORTERO, en donde podras gozar de muchos beneficios y comodidades,


    En este correo encontraran un usuario y contraseña para que ingresen al siguente enlace, el

    <p><strong>Nombre Completo: </strong>{{$contacto['name']}}</p>
    <p><strong>Correo Electrónico: </strong>{{$contacto['email']}}</p>
    <p><strong>Numero Celular: </strong>{{$contacto['celular']}}</p>
    <p><strong>Rol en la Copropiedad: </strong>{{$contacto['rol']}}</p>
    <p><strong>Numero de Unidades: </strong>{{$contacto['unidades']}}</p>
    <p><strong>Mensaje: </strong>{{$contacto['mensaje']}}</p>

</body>
</html>
