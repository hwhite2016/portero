<div>
    @php $texto = 'o' @endphp
    <div class="card">
    	<div class="card-header">
    		<div class="row">
  				<div class="col-4 col-md-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Filas:</span>
                            </div>
                            <select wire:model="cant" class="form-control select2">
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-8 col-md-6">
    				<input wire:model="search" class="form-control" placeholder="Buscar"/>
    			</div>
                <div class="col-12 col-md-4">
                    @can('admin.unidads.create')
                    {!! Form::open(['route'=>'admin.unidads.create', 'method'=>'get']) !!}
                    @if (isset($bloqueid))
                        {!! Form::hidden('bloqueid', $bloqueid) !!}
                    @endif
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nueva Unidad</button>
                    {!! Form::close() !!}
                    @endcan
                    <a class="btn btn-default float-right mr-2" data-toggle="tooltip" title="Ver residentes" href="{{route('admin.residentes.index')}}"><i class="fas fa-angle-double-right"></i></a>
                    <a class="btn btn-default float-right mr-2" data-toggle="tooltip" title="Ver bloques" href="{{route('admin.bloques.index')}}"><i class="fas fa-angle-double-left"></i></a>
                </div>
    		</div>

    	</div>
    	@if($unidads->count())
        @php if($search) $texto = $search @endphp
	    	<div class="card-body">
				<div class="table-responsive">
                    <a class="btn btn-sm btn-default mb-2 mt-1" href="{{ route('admin.unidads.export', $texto) }}"><i class="far fa-file-excel"></i> Exportar a Excel</a>
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th scope="col" class="c-pointer" wire:click="order('bloquenombre')">
                                    Bloque
                                    {{-- Sort --}}
                                    @if ($sort == "bloquenombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('unidadnombre')">
                                    Unidad
                                    {{-- Sort --}}
                                    @if ($sort == "unidadnombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif

                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('claseunidadnombre')">
                                    Tipo
                                    {{-- Sort --}}
                                    @if ($sort == "claseunidadnombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('estadonombre')" width="15%">
                                    Estado
                                    {{-- Sort --}}
                                    @if ($sort == "estadonombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" width="12%">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidads as $unidad)
                                <tr>
                                    <td class="c-pointer" wire:click="edit({{$unidad->id}})">
                                        {{ $unidad->bloquenombre }}
                                    </td>
                                    <td class="c-pointer" wire:click="edit({{$unidad->id}})"> {{ $unidad->unidadnombre }} </td>
                                    <td class="c-pointer" wire:click="edit({{$unidad->id}})">
                                        {{ $unidad->claseunidadnombre }}
                                        <small> ({{ $unidad->claseunidaddescripcion }})</small>
                                    </td>
                                    <td class="c-pointer" wire:click="edit({{$unidad->id}})">
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
