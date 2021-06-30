
	<div class="card card-default">
		<div class="card-header">
			<h3 class="card-title">
				<i class="fas fa-lock"></i> Asignar rol
			</h3>
		</div>
	  	<div class="card-body">
			<div class="container">
				<div class="row">
                	@foreach($roles as $role)
					<div class="col-6 col-md-4">
						<label>
							{!! Form::checkbox('roles[]', $role->id, null, ['class'=>'mr-1']) !!}
							{{$role->name}}
						</label>
					</div>
					@endforeach
				</div>
			</div>

	  	</div>
	</div>
	<!-- /.card -->
