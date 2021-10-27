<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> --}}
<img src="https://www.portero.com.co/image/logo/logo-black.png" class="logo" alt="Portero en Linea Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
