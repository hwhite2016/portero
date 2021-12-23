@component('mail::message')

# Buen dia Sr(a). Administrador(a)

Se ha registrado un nuevo Propietario/Residente en la plataforma y esta a la espera de su validación para poder ingresar y disfrutar de los beneficios que esta le brinda.
<ul>
    <li><b>Nombre:</b> {{$contacto['name']}}</li>
    <li><b>Bloque:</b> {{$contacto['bloque']}}</li>
    <li><b>Unidad:</b> {{$contacto['unidad']}}</li>
</ul>

@component('mail::panel')
Haga click en el botón de abajo para ingresar a la plataforma, luego vaya a la opción <b>Unidades</b> para revisar los datos suministrados por el propietario, y si todo esta en orden, cambiar el estado a verificado.
@endcomponent

@component('mail::button', ['url' => url('/admin'), 'color' => 'primary'])
    Ingresar a la plataforma
@endcomponent

<br><br>
Atentamente,<br>
{{ config('app.name') }}
@endcomponent
