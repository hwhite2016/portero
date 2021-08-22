{{-- <strong>Copyright &copy; 2021 <a href="#">portero.com.co</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">
<b>Version</b> 1.0.0
</div> --}}

<a href="{{route('admin.zonas.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Zonas Comunes">
    <span style="font-size: 1.5em; color: Dodgerblue;">
        <i class="fas fa-swimmer"></i>
    </span>
</a>

<a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Correspondencia">
    <span style="font-size: 1.5em; color: Dodgerblue;">
        <i class="fas fa-inbox"></i>
    </span>
</a>

<a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Pqr">
    <span style="font-size: 1.5em; color: Dodgerblue;">
        <i class="fas fa-envelope"></i>
    </span>
</a>

<a href="{{route('admin.zonas.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Mi Cuenta">
    <span style="font-size: 1.5em; color: Dodgerblue;">
        <i class="fas fa-user"></i>
    </span>
</a>

<a href="{{route('admin.index')}}" class="btn btn-default" data-toggle="tooltip" title="Home">
    <span style="font-size: 1.5em; color: Dodgerblue;">
        <i class="fas fa-home"></i>
    </span>
</a>

{{-- @can('admin.zonas.index')
    <a href="{{route('admin.zonas.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Zonas Comunes">
        <i class="fas fa-swimmer"></i>
    </a>
@endcan

@can('admin.seguimiento.index')
    <a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Correspondencia">
        <i class="fas fa-inbox"></i>
    </a>
@endcan

@can('admin.seguimiento.index')
    <a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Visitantes">
        <i class="fas fa-user-clock"></i>
    </a>
@endcan

@can('admin.seguimiento.index')
    <a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Pqr">
        <i class="fas fa-envelope"></i>
    </a>
@endcan

@can('admin.seguimiento.index')
    <a href="{{route('admin.seguimiento.index')}}" class="btn btn-default  float-right mr-2" data-toggle="tooltip" title="Mi Cuenta">
        <i class="fas fa-user"></i>
    </a>
@endcan

@can('admin.seguimiento.index')
    <a href="{{route('admin.seguimiento.index')}}" class="btn btn-default" data-toggle="tooltip" title="Home">
        <i class="fas fa-home"></i>
    </a>
@endcan --}}
