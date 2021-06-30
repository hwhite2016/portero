<div>
    <div class="card">
    	<div class="card-header">
    		<div class="row">
  				<div class="col-8">
    				<input wire:model="search" class="form-control" placeholder="Ingrese el nombre del rol"/>
    			</div>
				@can('admin.roles.create')
				<div class="col-4">
    				<a class="btn btn-secondary float-right" href="{{route('admin.roles.create')}}">Crear Rol</a>
    			</div>
    			@endcan
    		</div>
    	</div>
    	@if($roles->count())
	    	<div class="card-body">
	    		<table class="table table-striped">
	    			<thead>
	    				<tr>
	    					<th>ID</th>
	    					<th>Role</th>
	    					<th colspan="2"></th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@foreach($roles as $role)
	    					<tr>
	    						<td> {{$role->id}} </td>
	    						<td> {{$role->name}} </td>
	    						<td width="10px">
	    							@can('admin.roles.edit')
	    							<a class="btn btn-sm btn-primary" href="{{route('admin.roles.edit', $role)}}">Editar</a>
	    							@endcan
	    						</td>
	    						<td width="10px">
	    							@can('admin.roles.destroy')
	    							{!! Form::model($role, ['route'=>['admin.roles.destroy', $role], 'method'=>'delete']) !!}
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
	    	<div class="card-footer">
	    		{{$roles->links()}}
	    	</div>
	    @else
	    	<div class="card-body">
	    		<strong>No hay registros.</strong>
	    	</div>
	    @endif

    </div>
</div>