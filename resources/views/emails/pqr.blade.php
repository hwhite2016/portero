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
    {{-- <img src="{{ $message->embed('https://www.portero.com.co/image/logo/logo-black.png') }}"> --}}
    <p></p>
    @if($contacto['fase'] == 'create')  {{--CREATE--}}
        @if($contacto['usuario'] == 'Agente')
            <div class="justify-content-center">
                <b>Ha sido registrado un nuevo ticket</b><p></p>
                <b>Tipo de Ticket:</b> {{$contacto['tipo']}}<br>
                <b>Asunto:</b> {{$contacto['asunto']}}<br>
                <b>Asignado a:</b> {{$contacto['agente']}}<br>
                <b>Fecha de radicación:</b> {{strftime("%d de %B de %Y a la(s) %H:%M ", strtotime($contacto['fecha_radicado']))}}<br>
                <b>Plazo de respuesta:</b> {{$contacto['tiempo']}} día(s) hábil(es). → {{$contacto['plazo']}}<br>

                <p></p>
                <b>Conjunto:</b> {{$contacto['conjuntonombre']}}<br>
                <b>Nombres:</b> {{$contacto['personanombre']}}<br>
                <b>Unidad:</b> {{$contacto['unidad']}}<br>
                <b>Documento:</b> {{$contacto['tipodocumentoabreviatura']}} {{$contacto['personadocumento']}}<br>
                <b>Celular:</b> {{$contacto['personacelular']}}<br>
                <b>Email:</b> {{$contacto['personacorreo']}}<br>
                <b>Detalle del caso:</b> {{$contacto['mensaje']}}<br>

                <p>Para hacer seguimiento del caso ingrese a la plataforma <b>Portero en Linea</b> en la opción <b>PQRS</b> haciendo <a class="text-primary" href="{{route('admin.pqrs.edit', $contacto['id'])}}">click acá</a>.</p>
            </div>

        @elseif($contacto['usuario'] == 'Residente')
            <div class="justify-content-center">
                <b>Su caso ha sido radicado.</b>
                <p>Señor(a)</p>

                <p>{{$contacto['personanombre']}}</p>

                <p>Cordial saludo:</p>

                <p>En atención a su comunicado dirigido a <u>{{$contacto['agente']}}</u> de {{$contacto['conjuntonombre']}}, de manera atenta informamos
                que su caso ha sido registrado y direccionado a través del servicio de PQRS de la plataforma Portero en linea, con el fin que
                se continúe con el trámite y se emita la correspondiente respuesta dentro de los términos establecidos por la Ley.</p>

                <p>Para ingresar al servicio tenga en cuenta la siguiente información:</p>

                <b>Fecha de radicación:</b> {{strftime("%d de %B de %Y a la(s) %H:%M ", strtotime($contacto['fecha_radicado']))}}<br>
                <b>Plazo de respuesta:</b> {{$contacto['tiempo']}} día(s) hábil(es). → {{$contacto['plazo']}}<br>

                <p>El código de radicado del ticket es: <b>{{$contacto['radicado']}}</b></p>

                <p>Para hacer seguimiento del caso ingrese a la plataforma <b>Portero en Linea</b> en la opción <b>PQRS</b> haciendo <a class="text-primary" href="{{route('admin.pqrs.edit', $contacto['id'])}}">click acá</a>.</p>

                <p>Para <u>{{$contacto['agente']}}</u> es muy significativo interactuar con usted; por esta razón, le
                invitamos a mantener actualizada su información de contacto para brindarle un mejor servicio y atención.
                Recuerde que podrá consultar el estado y detalle de su caso ingresando directamente a la plataforma Portero en Linea.</p>

                <p>Agradecemos su atención.</p>

                <p>Cordialmente,</p>

                <p><b>{{$contacto['agente']}}</b><br>{{$contacto['conjuntonombre']}}</p>

                <p></p>
                <p><b>AVISO IMPORTANTE:</b> Este correo es enviado desde la plataforma Portero en Linea como respuesta automática en el registro, clasificación y/o atención de su caso. Esta comunicación no debe ser considerada como respuesta sino como medio de información para indicar la ruta que inicia su {{$contacto['tipo']}} en la plataforma Portero en Linea, frente a los organismos que les corresponde dar respuesta definitiva. Por favor, no responder a esta dirección de correo, ya que no es revisada por ningún usuario.</p>
            </div>
        @endif
    @elseif($contacto['fase'] == 'closed')  {{--CLOSED--}}

        <b>El ticket ha sido cerrado por el residente.</b>
        <p><b>Motivo del cierre:</b> <u>{{$contacto['motivo']}}</u></p>
        <b>Tipo de Ticket:</b> {{$contacto['tipo']}}<br>
        <b>Asunto:</b> {{$contacto['asunto']}}<br>
        <b>Asignado a:</b> {{$contacto['agente']}}<br>
        <b>Detalle del caso:</b> {{$contacto['mensaje']}}<br>

        <p>Para hacer seguimiento del caso ingrese a la plataforma <b>Portero en Linea</b> en la opción <b>PQRS</b> haciendo <a class="text-primary" href="{{route('admin.pqrs.edit', $contacto['id'])}}">click acá</a>.</p>

    @elseif($contacto['fase'] == 'seguimiento')  {{--SEGUIMIENTO--}}
        @if($contacto['usuario'] == 'Agente')
            <div class="justify-content-center">
                <b>El residente interactuo con el ticket</b>
                <p><ul>
                    @foreach($contacto['texto'] as $item)
                        <li>{{$item}}</li>
                    @endforeach
                </ul></p>
                <b>Tipo de Ticket:</b> {{$contacto['tipo']}}<br>
                <b>Asunto:</b> {{$contacto['asunto']}}<br>
                <b>Asignado a:</b> {{$contacto['agente']}}<br>
                <p></p>
                <b>Nombres:</b> {{$contacto['personanombre']}}<br>
                <b>Unidad:</b> {{$contacto['unidad']}}<br>
                <b>Email:</b> {{$contacto['personacorreo']}}<br>
                <b>Detalle del caso:</b> {{$contacto['mensaje']}}<br>

                <p>Para hacer seguimiento del caso ingrese a la plataforma <b>Portero en Linea</b> en la opción <b>PQRS</b> haciendo <a class="text-primary" href="{{route('admin.pqrs.edit', $contacto['id'])}}">click acá</a>.</p>
            </div>
        @else
            <div class="justify-content-center">
                <b>{{$contacto['agente']}} interactuo con el ticket</b>
                <p><ul>
                @foreach($contacto['texto'] as $item)
                    <li>{{$item}}</li>
                @endforeach
                </ul></p>
                <b>Tipo de Ticket:</b> {{$contacto['tipo']}}<br>
                <b>Asunto:</b> {{$contacto['asunto']}}<br>
                <b>Asignado a:</b> {{$contacto['agente']}}<br>
                <p></p>
                <b>Nombres:</b> {{$contacto['personanombre']}}<br>
                <b>Unidad:</b> {{$contacto['unidad']}}<br>
                <b>Email:</b> {{$contacto['personacorreo']}}<br>
                <b>Detalle del caso:</b> {{$contacto['mensaje']}}<br>

                <p>Para hacer seguimiento del caso ingrese a la plataforma <b>Portero en Linea</b> en la opción <b>PQRS</b> haciendo <a class="text-primary" href="{{route('admin.pqrs.edit', $contacto['id'])}}">click acá</a>.</p>
            </div>
        @endif
    @endif

</body>
</html>
