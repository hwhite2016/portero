@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <style>
        .login-logo,
        .register-logo {
            font-size: 2.1rem;
            font-weight: 300;
            margin-bottom: -0.1rem;
            text-align: center;
        }
        </style>
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="{{ $auth_type ?? 'login' }}-box">



        {{-- Card Box --}}
        <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-info') }}">

            {{-- Logo --}}
            {{-- <div class="{{ $auth_type ?? 'login' }}-logo mb-1">
                <a href="{{ $dashboard_url }}" class="h1">
                    <img src="{{ asset(config('adminlte.logo_img')) }}" height="50">
                    {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                </a>
            </div> --}}


            {{-- Card Header --}}
            {{-- @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif --}}

            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <div class="{{ $auth_type ?? 'login' }}-logo">
                        <a href="{{ $dashboard_url }}" class="h2">
                            <img class="mb-2" src="{{ asset(config('adminlte.logo_img')) }}" height="40">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                    </div>
                </div>
            @endif


            {{-- Card Body --}}
            <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">

                @if(session('info'))
                    <div class="alert alert-default-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{session('info')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @hasSection('auth_header')
                    <p class="login-box-msg">@yield('auth_header')</p>
                @endif


                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif

        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
