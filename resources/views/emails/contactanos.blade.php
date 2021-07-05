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

    <h1>Datos de nuevo interesado:</h1>
    <p><strong>Nombre Completo: </strong>{{$contacto['name']}}</p>
    <p><strong>Correo Electrónico: </strong>{{$contacto['email']}}</p>
    <p><strong>Numero Celular: </strong>{{$contacto['celular']}}</p>
    <p><strong>Rol en la Copropiedad: </strong>{{$contacto['rol']}}</p>
    <p><strong>Numero de Unidades: </strong>{{$contacto['unidades']}}</p>
    <p><strong>Mensaje: </strong>{{$contacto['mensaje']}}</p>

</body>
</html>
