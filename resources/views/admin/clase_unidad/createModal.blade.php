
<div class="card card-primary">

    {{-- <div class="card-header bg-primary">
        <h1 class="card-title">CREAR NUEVO TIPO DE UNIDAD</h1>
    </div> --}}
    <!-- /.card-header -->
    <div class="card-body">
        {{ Form::hidden('modal', 1) }}
        <div class="row">
            <div class="col-12">
                <div class="form-group"> <!-- Conjunto -->
                    {{ Form::label('conjuntoid', 'Conjunto') }}
                    {!! Form::select('conjuntoid', $conjuntos, null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un conjunto']) !!}
                    @error('conjuntoid')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Nombre del Tipo -->
                    {{ Form::label('claseunidadnombre', '* Nombre') }}
                    {{ Form::text('claseunidadnombre', null, array('placeholder' => 'Ej: Tipo A, Tipo B, Clase C ...', 'class' => 'form-control')) }}
                    @error('claseunidadnombre')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Descripcion -->
                    {{ Form::label('claseunidaddescripcion', 'Descripcion') }}
                    {{ Form::text('claseunidaddescripcion', null, array('placeholder' => 'Ej: 75 mts, 90 mts, 120 mts ...', 'class' => 'form-control')) }}
                    @error('claseunidaddescripcion')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group"> <!-- Cuota de Administracion -->
                    {{ Form::label('claseunidadcuota', 'Cuota Admon') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        {{ Form::number('claseunidadcuota', null, array('placeholder' => '0', 'class' => 'form-control')) }}
                    </div>
                    @error('claseunidadcuota')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                    @enderror
                </div>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
    {{-- <div class="card-footer">
        <div class="row">
            <div class="col-8 col-sm-10"><a href="{{route('admin.clase_unidads.index')}}">Volver al listado de los tipos</a></div>
            <div class="col-2 col-sm-1">
                {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary']) !!}
            </div>
            <div class="col-2 col-sm-1">
                {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div> --}}
    <!-- /.card-footer -->

</div>
<!-- /.card -->
