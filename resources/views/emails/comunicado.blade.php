{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h1{
            color:rgb(47, 86, 145);
        }
    </style>

</head>
<body>

    <h1>{{$contacto['tipo']}}:</h1>
    <p><strong>{{$contacto['titulo']}}</strong></p>

    <p>{{$contacto['mensaje']}}</p>

</body>
</html> --}}

@component('mail::message')

# {{$contacto['tipo']}}:
<b>De:</b> Administración - {{$contacto['conjunto']}} <br>
<b>Para:</b> {{$contacto['name']}}

<strong>{{$contacto['titulo']}}</strong>

@component('mail::panel')
{{$contacto['mensaje']}}
@endcomponent


<small>
    Favor no responder este mensaje que ha sido emitido automáticamente por la plataforma portero.com.co
</small>

<br><br>
Atentamente,<br>
{{$contacto['administrador']}}
<br>Administrador(a)
@endcomponent
