<div>
    <div class="card">
    	<div class="card-header">
    		<div class="row">
  				<div class="col-12">
                    <input id="search" wire:model="search" class="form-control" placeholder="No. del apartamento, nombre residente, placa del vehiculo ..."/>
                    {{-- <div class="input-group">
                        <input id="search" wire:model="search" class="form-control" placeholder="No. del apartamento, nombre residente, placa del vehiculo ..."/>
                        <div class="input-group-prepend">
                            <a href="#" id="getResidente" class="input-group-text"><i class="fas fa-search"></i></a>
                        </div>
                    </div> --}}
    			</div>
    		</div>
    	</div>
        <!-- /.card-header -->

        @if($unidades->count())
            <div class="card-body">
                <div class="row">
                    @foreach($unidades as $unidad)
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4	col-xxl-3">
                            <div class="card card card-primary shadow-lg {{($unidades->count()<=2?'':'collapsed-card')}}">
                                <div class="card-header">
                                    <h3 class="card-title">{{$unidad->bloquenombre}} / {{$unidad->unidadnombre}}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{($unidades->count()<=2?'minus':'plus')}}"></i>
                                        </button>
                                      </div>
                                      <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-user mr-1"></i> Residentes</strong> <small class="font-italic"> (# Documento / Nombres)</small>

                                    <p class="text-muted">
                                        @php
                                           $residentes = json_decode($unidad->residentes, true);
                                        @endphp

                                        @foreach($residentes as $residente => $valor)
                                            <span><i class="fas fa-caret-right"></i> . . . {{substr($residente, strpos($residente, '|') - 3, 50)}}</span><span class="badge badge-{{($valor=='Propietario'?'primary':'secondary')}} float-right">{{$valor}}</span><br>
                                        @endforeach
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-car mr-1"></i> Vehiculos</strong> <small class="font-italic"> (Marca / Placas)</small>

                                    <p class="text-muted">
                                        @php
                                           $vehiculos = json_decode($unidad->vehiculos, true);
                                        @endphp

                                        @foreach($vehiculos as $vehiculo => $valor)
                                            @if($vehiculo <> '0')
                                                <span><i class="fas fa-caret-right"></i> {{$vehiculo}}</span><span class="badge badge-secondary float-right">{{$valor}}</span><br>
                                            @else
                                                <small class="text-secondary">No hay vehiculos registrados</small>
                                            @endif
                                        @endforeach
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-parking"></i> Parqueaderos</strong>

                                    <p class="text-muted">
                                        @php
                                           $parqueaderos = json_decode($unidad->parqueaderos, true);
                                        @endphp

                                        @foreach($parqueaderos as $parqueadero => $valor)
                                            @if($parqueadero <> '0')
                                                <span><i class="fas fa-caret-right"></i> Piso {{$valor}} - Parqueadero # {{$parqueadero}}</span><br>
                                            @else
                                                <small class="text-secondary">No tiene parqueaderos asignados</small>
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$unidades->links()}}
            </div>
            <!-- /.card-footer -->
        @else
            <div class="card-body">
                <div class="alert alert-default-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <div>
                        No se encontraron registros
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        @endif
    </div>
    <!-- /.card -->
</div>

