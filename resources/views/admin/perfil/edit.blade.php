@extends('adminlte::page')

@section('title', 'Residentes')

@section('plugins.Select2', 'true')
@section('plugins.Inputmask', 'true')
@section('plugins.Timepicker', 'true')
@section('plugins.Toastr', 'true')

@section('content_header')

@stop

@section('content')
<br>
<div class="row">
    @if($unidads)
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ Auth::user()->adminlte_image() }}"
                        alt="{{ Auth::user()->name }}">
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-muted text-center">
                    {{$user->email}}
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>Barrio</b> <a class="float-right">{{$unidads->barrionombre}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Conjunto</b> <a class="float-right">{{ Auth::user()->adminlte_desc() }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Bloque</b> <a class="float-right">{{$unidads->bloquenombre}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Unidad</b> <a class="float-right">{{$unidads->unidadnombre}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Residentes</b>
                    <a class="float-right">
                        @foreach($residentes as $residente)
                            <span class="float-right">{{$residente->personanombre}}</span><br>
                        @endforeach
                    </a>
                    </li>
                    <li class="list-group-item">
                    <b>Vehiculos</b>
                    <a class="float-right">
                        @php
                            $vehiculos = json_decode($unidads->vehiculos, true);
                        @endphp

                        @foreach($vehiculos as $vehiculo => $valor)
                            @if($vehiculo <> '0')
                                {{$vehiculo}} <br><span class="badge badge-light float-right border">{{$valor}}</span><br>
                            @else
                                N/V
                            @endif
                        @endforeach
                    </a>
                    </li>
                    <li class="list-group-item">
                    <b>Parqueaderos</b>
                    <a class="float-right">
                        @php
                            $parqueaderos = json_decode($unidads->parqueaderos, true);
                        @endphp

                        @foreach($parqueaderos as $parqueadero => $valor)
                            @if($parqueadero <> '0')
                                {{$parqueadero}} <span class="badge badge-light border">Nivel {{$valor}}</span> <br>
                            @else
                                N/P
                            @endif
                        @endforeach
                    </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    @endif



    <div class="col-md-4">
        <div class="card">
            {!! Form::model($persona, ['route'=>['admin.perfil.update', $persona], 'method'=>'put']) !!}
            {!! Form::hidden('module', 1) !!}
            @csrf
            {{-- @method('POST') --}}
            <div class="card-header bg-light">
                <h1 class="card-title">
                    <span class="text-secondary"><i class="fas fa-user-edit"></i></span>
                    <label>Datos Personales</label>
                </h1>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('conjuntoid', 'Copropiedad') }}
                            {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control select2','style'=>'width: 100%', 'disabled']) !!}
                            @error('conjuntoid')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Tipo Documento -->
                            {{ Form::label('tipodocumentoid', 'Tipo Documento') }}
                            {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control select2','style'=>'width: 100%', 'disabled', 'data-placeholder'=>'Seleccione un tipo de documento']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Documento ID -->
                            {{ Form::label('personadocumento', 'Documento ID') }}
                            {!! Form::text('personadocumento', $persona->personadocumento, array('placeholder' => 'Ingrese el No. de documento', 'class' => 'form-control', 'disabled')) !!}
                            @error('personadocumento')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Fecha de Nacimiento -->
                            {{ Form::label('personafechanacimiento', 'Fecha de Nacimiento') }}
                            <div class="input-group date" id="fechanacimiento" data-target-input="nearest">
                                {!! Form::text('personafechanacimiento', $persona->personafechanacimiento, array('data-toggle' => 'datetimepicker','data-target' => '#fechanacimiento', 'class' => 'form-control datetimepicker-input')) !!}
                                <div class="input-group-append" data-target="#fechanacimiento" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            @error('personafechanacimiento')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Nombres -->
                            {{ Form::label('personanombre', '* Nombres y Apellidos') }}
                            {!! Form::text('personanombre', $persona->personanombre, array('placeholder' => 'Ej: Jose Perez Marquez', 'class' => 'form-control')) !!}
                            @error('personanombre')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Correo -->
                            {{ Form::label('personacorreo', 'Correo') }}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                </div>
                                {{ Form::email('personacorreo', $persona->personacorreo, array('class' => 'form-control')) }}

                            </div>
                            @error('personacorreo')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Numero celular -->
                            {{ Form::label('personacelular', 'Numero Celular') }}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                {{ Form::text('personacelular', $persona->personacelular, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}

                            </div>
                            @error('personacelular')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarDatos']) !!}
            </div>
            <!-- /.card-footer -->
            {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>


    <div class="col-md-4">
        <div class="card">
            {!! Form::model($user, ['route'=>['admin.perfil.update', $user], 'method'=>'put']) !!}
            {!! Form::hidden('module', 2) !!}
            @csrf
            {{-- @method('POST') --}}
            <div class="card-header bg-light">

                <h1 class="card-title">
                    <span class="text-secondary"><i class="fas fa-key"></i></span>
                    <label>Cambiar Contraseña</label>
                </h1>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Password Actual -->
                            {{ Form::label('current_password', '* Contraseña actual') }}
                            {{-- {!! Form::password('password_act', null, ['class' => 'form-control']) !!} --}}
                            <input type="password" name="current_password" id="current_password" class="form-control" value="{{old('current_password')}}">
                            @error('current_password')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Password Nuevo -->
                            {{ Form::label('password', '* Nueva contraseña') }}
                            {{-- {!! Form::password('password', null, ['class' => 'form-control']) !!} --}}
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group"> <!-- Confirmar Password Nuevo -->
                            {{ Form::label('password_confirmation', '* Confirmar nueva contraseña') }}
                            {{-- {!! Form::password('password_new2', null, ['class' => 'form-control']) !!} --}}
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <small class="text-danger">
                                    {{$message}}
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'guardarPassword']) !!}
            </div>
            <!-- /.card-footer -->
            {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
</div>





@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    @if(session('info'))
        <script type="text/javascript">
            toastr.success("{{session('info')}}")
        </script>
    @endif
    @if(session('error'))
        <script type="text/javascript">
            toastr.error("{{session('error')}}")
        </script>
    @endif

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            $(":input").inputmask();

            $('#fechanacimiento').datetimepicker({
                format: 'L',
                format: 'YYYY/MM/DD'
            });

        })
    </script>
@stop
