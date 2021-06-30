<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#mascotasModal" data-whatever="{{$unidad->id}}">
            <i class="fas fa-plus-circle"></i> &nbsp Agregar
        </a>
    </div>
    <div class="col-12 mt-2">
        <table class="table table-striped table-bordered table-hover table-sm nowrap">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Raza</th>
                <th>Edad (meses)</th>
                <th width="5%">...</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mascotas as $mascota)
                <tr>
                  <td> {{ $mascota->tipomascotanombre }} </td>
                  <td> {{ $mascota->mascotaraza }} </td>
                  <td> {{ $mascota->mascotaedad }} </td>
                  <td>
                      @can('admin.mascotas.destroy')
                        {!! Form::model($mascota, ['route'=>['admin.mascotas.destroy', $mascota->id], 'method'=>'delete', 'class'=>'frm_delete']) !!}
                        @csrf
                        {!! Form::hidden('mascotas', 1) !!}
                        {{-- @method('DELETE') --}}
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Mascota"><i class="far fa-trash-alt"></i></button>

                        {!! Form::close() !!}
                      @endcan
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</div>

<!-- Modal -->
{!! Form::open(['route'=>'admin.mascotas.store', 'method'=>'post']) !!}
    @csrf
<div class="modal fade" id="mascotasModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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






