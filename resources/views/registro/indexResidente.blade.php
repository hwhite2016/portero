<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#residentesModal" data-whatever="{{$registro->unidadid}}">
            <i class="fas fa-plus-circle"></i> &nbsp Agregar residente
        </a>
    </div>
    <div class="col-12 mt-2">
        <table class="table table-striped table-bordered table-hover table-sm nowrap">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Relacion</th>
                <th>Celular</th>
                <th width="5%">...</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($residentes as $residente)
                <tr>
                  <td> {{ $residente->personanombre }} </td>
                  <td> {{ $residente->tiporesidentenombre }} </td>
                  <td> {{ $residente->relationname }} </td>
                  <td> {{ $residente->personacelular }} </td>
                  <td>
                      {{-- @can('admin.residentes.destroy') --}}
                        {!! Form::model($residente, ['route'=>['registros.destroyResidente', $residente->id], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                        @csrf
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Residente"><i class="far fa-trash-alt"></i></button>

                        {!! Form::close() !!}
                      {{-- @endcan --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>

<!-- Modal -->
{!! Form::open(['route'=>'registros.storeResidente', 'method'=>'post']) !!}
    @csrf
<div class="modal fade" id="residentesModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
            {!! Form::reset('Cancelar', ['class'=>'btn btn-secondary', 'data-dismiss'=>'modal']) !!}
            {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button> --}}
        </div>
      </div>
    </div>
</div>
{!! Form::close() !!}






