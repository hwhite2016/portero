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
                    @can('admin.anuncios.create')
                    {!! Form::open(['route'=>'admin.anuncios.create', 'method'=>'get']) !!}
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> &nbsp Nuevo Comunicado</button>
                    {!! Form::close() !!}
                    @endcan
                </div>
    		</div>

    	</div>
    	@if($anuncios->count())
        @php if($search) $texto = $search @endphp
	    	<div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th scope="col"  class="c-pointer" wire:click="order('tipoanuncionombre')">
                                    Tipo de Comunicado
                                    {{-- Sort --}}
                                    @if ($sort == "tipoanuncionombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('anuncionombre')">
                                    Titulo
                                    {{-- Sort --}}
                                    @if ($sort == "anuncionombre")
                                        @if ($direction == "ASC")
                                            <i class="fas fa-sort-up float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-down float-right mt-1"></i>
                                        @endif

                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif

                                </th>
                                <th scope="col" class="c-pointer">
                                    Destino
                                </th>
                                <th scope="col" class="c-pointer" wire:click="order('anunciofechaentrega')" width="15%">
                                    Ultimo envío
                                    {{-- Sort --}}
                                    @if ($sort == "anunciofechaentrega")
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
                            @foreach($anuncios as $anuncio)
                                <tr>
                                    <td class="c-pointer" wire:click="edit({{$anuncio->id}})">
                                        {{ $anuncio->tipoanuncionombre }}
                                    </td>
                                    <td class="c-pointer" wire:click="edit({{$anuncio->id}})">
                                        @if($anuncio->anuncioadjunto)
                                            <i class="fas fa-paperclip text-secondary"></i>
                                        @endif
                                        {{ $anuncio->anuncionombre }}
                                    </td>
                                    <td>
                                        @if($anuncio->bloqueid)
                                            @if($anuncio->unidadid)
                                                Unidad(es) de {{$anuncio->bloquenombre}}
                                            @else
                                                {{$anuncio->bloquenombre}}
                                            @endif
                                        @else
                                            Todo el Conjunto
                                        @endif
                                    </td>
                                    <td class="c-pointer text-center" wire:click="edit({{$anuncio->id}})">
                                        {{ $anuncio->anunciofechaentrega }}
                                    </td>

                                    <td class="text-center">
                                        @can('admin.anuncios.destroy')
                                        {!! Form::model($anuncio, ['route'=>['admin.anuncios.destroy', $anuncio], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                                        @endcan

                                        @can('admin.anuncios.edit')
                                            <a href="{{route('admin.anuncios.enviar', $anuncio->id)}}" id="enviar_{{$anuncio->id}}" class="enviar btn btn-sm btn-success">
                                                Enviar
                                            </a>
                                            <a href="{{route('admin.anuncios.edit', $anuncio->id)}}" class="btn btn-sm btn-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('admin.anuncios.destroy')
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
	    		{{$anuncios->links()}}
	    	</div>
	    @else
	    	<div class="card-body">
	    		<strong>No hay registros.</strong>
	    	</div>
	    @endif

    </div>
</div>

