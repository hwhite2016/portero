@component('mail::message')

# Hola, {{$contacto['name']}}

Reciba un cordial saludo por parte de la Administración. ¡Ya eres miembro de esta plataforma!

@component('mail::panel')
Los datos que suministró en el formulario de registro fueron validados por la administracion, asi que a partir de este momento puede ingresar a nuestra plataforma y gozar de los benefecios que le ofrece.
@endcomponent

@component('mail::button', ['url' => url('/admin'), 'color' => 'primary'])
    Ingresar a la plataforma
@endcomponent

<small>
    <p>Tendra acceso a los siguientes modulos:</p>
    <ol>
        <li>Programación y reporte de Visitantes</li>
        <li>Notificación de Correspondencia y/o Paqueteria</li>
        <li>Reserva de Zonas Comunes</li>
        <li>Comunicados (Email - Telegram)</li>
        <li>Documentos en linea</li>
        <li>Estructura Orgánica</li>
        <li>Sistema de PQRS (Peticiones, Quejas, Reclamos y Sugerencias)</li>
        <li>Pago Cuota de Administración (Muy pronto)</li>
        <li>Cartera (Muy pronto)</li>
    </ol>

    Si tiene preguntas, por favor coloquese en contacto con la administración de su conjunto
</small>

<br><br>
Atentamente,<br>
{{ config('app.name') }}
@endcomponent
