<div>
    <br>
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
                    @can('admin.parqueaderos.create')
                    {!! Form::open(['route'=>'admin.parqueaderos.create', 'method'=>'get']) !!}
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Parqueadero</button>
                    {!! Form::close() !!}
                    @endcan
                </div>
    		</div>

    	</div>
    	@if($parqueaderos->count())
        @php if($search) $texto = $search @endphp
	    	<div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th scope="col"  class="c-pointer" wire:click="order('tipoparqueaderonombre')">
                                    Tipo
                                    {{-- Sort --}}
                                    @if ($sort == "tipoparqueaderonombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('parqueaderonumero')">
                                    Parqueadero
                                    {{-- Sort --}}
                                    @if ($sort == "parqueaderonumero")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif

                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('parqueaderopiso')">
                                    Piso
                                    {{-- Sort --}}
                                    @if ($sort == "parqueaderopiso")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('parqueaderoestado')">
                                    Estado
                                    {{-- Sort --}}
                                    @if ($sort == "parqueaderoestado")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parqueaderos as $parqueadero)
                                <tr>
                                    <td class="c-pointer" wire:click="edit({{$parqueadero->id}})">
                                        {{ $parqueadero->tipoparqueaderonombre }}
                                    </td>
                                    <td class="c-pointer" wire:click="edit({{$parqueadero->id}})">
                                        {{ $parqueadero->parqueaderonumero }}
                                        @if($parqueadero->unidadnombre)
                                            <small> ({{ $parqueadero->unidadnombre }})</small>
                                        @endif
                                    </td>
                                    <td class="c-pointer" wire:click="edit({{$parqueadero->id}})">
                                        {{ $parqueadero->parqueaderopiso }}
                                    </td>
                                    <td class="c-pointer text-center" wire:click="edit({{$parqueadero->id}})">
                                        <span class="badge {{$parqueadero->estadoparqueaderonombre == 'Disponible' ? 'bg-success' : 'bg-danger'}}">{{$parqueadero->estadoparqueaderonombre}}</span>

                                    </td>

                                    <td class="text-center">
                                        @can('admin.parqueaderos.destroy')
                                        {!! Form::model($parqueadero, ['route'=>['admin.parqueaderos.destroy', $parqueadero], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                        @endcan

                                        @can('admin.parqueaderos.edit')
                                            <a href="{{route('admin.parqueaderos.edit', $parqueadero->id)}}" class="btn btn-sm btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('admin.parqueaderos.destroy')
                                        @csrf
                                        <button class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>

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
	    		{{$parqueaderos->links()}}
	    	</div>
	    @else
	    	<div class="card-body">
	    		<strong>No hay registros.</strong>
	    	</div>
	    @endif

    </div>
</div>

