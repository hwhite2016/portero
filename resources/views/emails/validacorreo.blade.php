@component('mail::message')

# Hola, {{$contacto['name']}}

Valide su correo para continuar el proceso de registro en {{$contacto['conjunto']}}, y asi poder gozar de los benefecios que éste le brinda.

@component('mail::panel')
Confirme que <u>{{$contacto['email']}}</u> es su dirección de correo electrónico haciendo clic en el botón
"Validar Correo" el cual estara habilitado solo por 24 horas.
@endcomponent

@component('mail::button', ['url' => url('registro/verify',array('email'=>$contacto['email'],'seed'=>$contacto['profile_photo_path'])), 'color' => 'primary'])
    Validar correo
@endcomponent

<small>
Usted recibió este correo electrónico porque esta intentando crear una cuenta en la plataforma Portero.com.co.
Si no fue usted simplemente ignore este correo, de lo contrario asegúrese de que nuestros mensajes lleguen a su bandeja de entrada
(y no a sus carpetas masivas o basura).
</small>

<br><br>
Atentamente,<br>
{{ config('app.name') }}
@endcomponent
