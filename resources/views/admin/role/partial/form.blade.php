<div class="form-group">
	{!! Form::label('name', 'Nombre') !!}
	{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Ingrese el nombre del rol']) !!}
	@error('name')
		<small class="text-danger">
			{{$message}}
		</small>
	@enderror
</div>

<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fas fa-lock"></i> Lista de permisos
		</h3>
	</div>
	<div class="card-body">
		<div class="container">
			<div class="row">
                @foreach($permissions as $permission)
                    <div class="col-6 col-md-4">
                        <label>
                            {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                            <small>{{$permission->description}}</small>
                        </label>
                    </div>
                @endforeach
			</div>
		</div>

	</div>
</div>
<!-- /.card -->






