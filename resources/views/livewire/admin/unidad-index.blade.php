<div>
    <div class="card">
    	<div class="card-header">
    		<div class="row">
  				<div class="col-6">
    				<input wire:model="search" class="form-control" placeholder="Buscar"/>
    			</div>
                <div class="col-6">
                    @can('admin.unidads.create')
                    {!! Form::open(['route'=>'admin.unidads.create', 'method'=>'get']) !!}
                    @if (isset($bloqueid))
                        {!! Form::hidden('bloqueid', $bloqueid) !!}
                    @endif
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Unidad{{$bloqueid}}</button>
                    {!! Form::close() !!}
                    @endcan
                    <a class="btn btn-warning float-right mr-2" data-toggle="tooltip" title="Ver residentes" href="{{route('admin.residentes.index')}}"><i class="fas fa-angle-double-right"></i></a>
                    <a class="btn btn-warning float-right mr-2" data-toggle="tooltip" title="Ver bloques" href="{{route('admin.bloques.index')}}"><i class="fas fa-angle-double-left"></i></a>
                </div>
    		</div>

    	</div>
    	@if($unidads->count())
	    	<div class="card-body">
				<div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Bloque</th>
                                <th>Unidad</th>
                                <th>Tipo</th>
                                <th width="15%">Estado</th>
                                <th width="12%">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidads as $unidad)
                                <tr>
                                    <td>
                                        <span class="text-uppercase"> {{ $unidad->bloquenombre }} </span>
                                    </td>
                                    <td> {{ $unidad->unidadnombre }} </td>
                                    <td>
                                        {{ $unidad->claseunidadnombre }}
                                        <small> ({{ $unidad->claseunidaddescripcion }})</small>
                                    </td>
                                    <td>
                                        @if($unidad->estado_id == 1)
                                            <span class="badge bg-light">Sin Registro</span>
                                        @elseif($unidad->estado_id == 2)
                                            <span class="badge bg-secondary"><i class="fas fa-cog"></i> En Proceso</span>
                                        @elseif($unidad->estado_id == 3)
                                            <span class="badge bg-info"><i class="fas fa-spell-check"></i> Por Verificar</span>
                                        @elseif($unidad->estado_id == 4)
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Verificado</span>
                                        @endif
                                    </td>

                                    <td>
                                        @can('admin.unidads.destroy')
                                        {!! Form::model($unidad, ['route'=>['admin.unidads.destroy', $unidad], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                        @endcan
                                        <a href="{{ route ('admin.residentes.show', $unidad->id) }}" class="btn btn-default btn-sm"  id="btn-unidad" data-toggle="tooltip" title="Ver Residentes"><i class="fas fa-user"></i> ({{ $unidad->residente_count }})</a>

                                        @can('admin.unidads.edit')
                                        @if (isset($id))
                                            <a href="{{route('admin.unidads.edit', $unidad->id)}}?bloqueid={{$id}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Unidad">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @else
                                            <a href="{{route('admin.unidads.edit', $unidad->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Editar Unidad">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        @endcan

                                        @can('admin.unidads.destroy')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Unidad"><i class="far fa-trash-alt"></i></button>

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
	    		{{$unidads->links()}}
	    	</div>
	    @else
	    	<div class="card-body">
	    		<strong>No hay registros.</strong>
	    	</div>
	    @endif

    </div>
</div>
