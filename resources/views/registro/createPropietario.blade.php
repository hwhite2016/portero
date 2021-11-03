<div class="row">
    <div class="col-md-12">
    <div class='alert alert-default-warning alert-dismissible fade show' role='alert'>
        <i class="fas fa-exclamation-triangle"></i>&nbsp;
        La información de esta pestaña solo debe ser diligenciada por el titular de la unidad.
        Luego haga click en el boton guardar para pasar a la pestaña de residentes.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
    </div>


    <div class="col-md-2">
        <div class="form-group"> <!-- Tipo Propietario -->
            {{ Form::label('tipopropietarioid', '* Titular') }}
            {!! Form::select('tipopropietarioid', $tipo_propietarios, old('tipopropietarioid'), ['class' => 'form-control  select2','style'=>'width: 100%']) !!}
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group"> <!-- Tipo Documento -->
            {{ Form::label('tipodocumentoid', '* Tipo Documento') }}
            {!! Form::select('tipodocumentoid', $tipo_documentos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un tipo de documento']) !!}
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group"> <!-- Documento ID -->
            {{ Form::label('personadocumento', '* Documento ID') }}
            {!! Form::text('personadocumento', null, array('placeholder' => 'Ingrese el No. de documento', 'class' => 'form-control', 'required')) !!}
            @error('personadocumento')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group"> <!-- Nombres -->
            {{ Form::label('personanombre', '* Nombres y Apellidos') }}
            {!! Form::text('personanombre', Auth::user()->name, array('placeholder' => 'Ej: Jose Perez Marquez', 'class' => 'form-control', 'required')) !!}
            @error('personanombre')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group"> <!-- Fecha de Nacimiento -->
            {{ Form::label('personafechanacimiento', 'Fecha de Nacimiento') }}
            <div class="input-group date" id="fechanacimiento" data-target-input="nearest">
                {!! Form::text('personafechanacimiento', null, array('data-toggle' => 'datetimepicker','data-target' => '#fechanacimiento', 'class' => 'form-control datetimepicker-input')) !!}
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

    <div class="col-md-4">
        <div class="form-group"> <!-- Correo -->
            {{ Form::label('personacorreo', '* Correo Electrónico') }}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                </div>
                {{ Form::email('personacorreo', Auth::user()->email, array('placeholder' => 'Ej: pedro@gmail.com', 'class' => 'form-control', 'required')) }}
            </div>
            @error('personacorreo')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group"> <!-- Numero celular -->
            {{ Form::label('personacelular', 'Numero Celular') }}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                </div>
                {{ Form::text('personacelular', null, array('placeholder' => '', 'class' => 'form-control', 'data-inputmask'=>'"mask": "(999) 999-9999"')) }}
                @error('personacelular')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group"> <!-- Reside -->
            {!! Form::label('reside', 'Reside en la Unidad') !!}
            {!! Form::select('reside', ['0'=>'NO', '1'=>'SI'], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'']) !!}
            @error('reside')
                <small class="text-danger">
                    {{$message}}
                </small>
            @enderror
        </div>
    </div>

</div>
