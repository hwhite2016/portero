<div>
    <div class="card">
	    <div class="card-body">
	    	{!! Form::open(['route'=>'admin.roles.store']) !!}
	    		<div class="form-group">
	    			{!! Form::label('name', 'Nombre') !!}
	    			{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Ingrese el nombre del rol']) !!}
	    		</div>

	    		<h2 class="h3">Lista de permisos</h2>
	    		@foreach($permissions as $permission)
	    			<div>
						<label>
							{!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
							{{$permission->name}}
						</label>
					</div>
	    		@endforeach

	    		{!! Form::submit('Crear rol', ['class'=>'btn btn-primary']) !!}
	    	{!! Form::close() !!}
	    </div>
    </div>
</div>
