<div>
    <div class="card">
    	<div class="card-header">
    		<div class="row">
  				<div class="col-8">
    				<input wire:model="search" class="form-control" placeholder="Ingrese el nombre o email del usuario"/>
    			</div>
				@can('admin.users.create')
				<div class="col-4">
    				<a class="btn btn-secondary float-right" href="{{route('admin.users.create')}}">Crear Usuario</a>
    			</div>
    			@endcan
    		</div>

    	</div>
    	@if($users->count())
	    	<div class="card-body">
				<div class="table-responsive">
	    		<table class="table table-striped">
	    			<thead>
	    				<tr>
	    					<th>ID</th>
	    					<th>Nombre</th>
	    					<th>Roles</th>

	    					<th colspan="2"></th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@foreach($users as $user)
	    					<tr>
	    						<td> {{$user->id}} </td>
	    						<td>
									{{$user->name}}
								</td>
                                <td>
                                    <span class="text-primary">{{$user->email}}</span>
                                </td>
	    						<td>
									@foreach ($user->roles as $rol)
										<span class="badge bg-secondary">{{$rol->name}}</span>
									@endforeach
								</td>

	    						<td width="10px">
	    							@can('admin.users.edit')
	    							<a class="btn btn-sm btn-primary" href="{{route('admin.users.edit', $user)}}">Editar</a>
	    							@endcan
	    						</td>
	    						<td width="10px">
	    							@can('admin.users.destroy')
	    							{!! Form::model($user, ['route'=>['admin.users.destroy', $user], 'method'=>'delete', 'class'=>'frm_delete']) !!}
	    								@csrf
	    								{!! Form::submit('Eliminar', ['class'=>'btn btn-danger btn-sm']) !!}
	    							{!! Form::close() !!}
	    							@endcan
	    						</td>
	    					</tr>
	    				@endforeach
	    			</tbody>
	    		</table>
				</div>
	    	</div>
	    	<div class="card-footer">
	    		{{$users->links()}}
	    	</div>
	    @else
	    	<div class="card-body">
	    		<strong>No hay registros.</strong>
	    	</div>
	    @endif

    </div>
</div>
