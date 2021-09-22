@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $password_rol_url = View::getSection('password_rol_url') ?? config('adminlte.password_rol_url', 'password/rol') )

@if (config('adminlte.use_route_url', false))
    @php( $password_rol_url = $password_rol_url ? route($password_rol_url) : '' )
@else
    @php( $password_rol_url = $password_rol_url ? url($password_rol_url) : '' )
@endif

@section('auth_header','Seleccione la Copropiedad a ingresar.')

@section('auth_body')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('home.show') }}" method="post">
        {{ csrf_field() }}

        {{-- Rol field --}}
        <div class="input-group mb-3">
            {!! Form::select('conjuntoid', $conjuntos, old('conjuntoid'), ['class' => 'form-control']) !!}
            {{-- <input type="email" name="rol" class="form-control {{ $errors->has('rol') ? 'is-invalid' : '' }}"
                   value="{{ old('rol') }}" placeholder="{{ __('adminlte::adminlte.rol') }}" autofocus> --}}
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-building {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('rol'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('rol') }}</strong>
                </div>
            @endif
        </div>

        {{-- Send reset link button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-sign-in-alt"></span>
            Ingresar
        </button>

    </form>

    <hr>
    <small>
    Leer los <a class="text-info" href="/terminos" target="_blank">términos y condiciones</a> y las <a class="text-info" href="/privacidad" target="_blank">politicas de privacidad.</a>
    </small>

@stop

@section('auth_footer')

@if (Route::has('login'))
    <a class="btn sign-in-btn focus-reset text-info"
    href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off"></i>&nbsp; Salir
    </a>

    <form id="logout-form" action="{{ config('adminlte.logout_url', 'logout') }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>
@endif

    {{-- Register link --}}
    {{-- @if($register_url)
        <p class="my-0">
            <a class="text-info" href="{{ $register_url }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif --}}
@stop
