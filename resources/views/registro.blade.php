@extends('adminlte::page')

@section('title', 'Registro')

@section('plugins.Select2', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Step', 'true')

@section('content_header')
    <h1>Registro</h1>
@stop

@section('content')

<div class="card card-default">
    {!! Form::open(['route'=>'admin.entregas.store', 'method'=>'post']) !!}
    <div class="card-header">
      <h3 class="card-title">bs-stepper</h3>
    </div>
    <div class="card-body p-0">
      <div class="bs-stepper">
        <div class="bs-stepper-header" role="tablist">
          <!-- your steps here -->
          <div class="step" data-target="#logins-part">
            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
              <span class="bs-stepper-circle">1</span>
              <span class="bs-stepper-label">Copropiedad</span>
            </button>
          </div>
          <div class="line"></div>
          <div class="step" data-target="#information-part">
            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
              <span class="bs-stepper-circle">2</span>
              <span class="bs-stepper-label">Datos del Propietario / Residente</span>
            </button>
          </div>
        </div>
        <div class="bs-stepper-content">
          <!-- your steps content here -->
            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> <!-- Pais -->
                                {{ Form::label('paisid', 'Pais') }}
                                {!! Form::select('paisid', [], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un pais']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> <!-- Ciudad -->
                                {{ Form::label('ciudadid', 'Ciudad') }}
                                {!! Form::select('ciudadid', [], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione una ciudad']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> <!-- Barrio -->
                                {{ Form::label('barrioid', 'Barrio') }}
                                {!! Form::select('barrioid', [], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione un barrio']) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"> <!-- Conjunto -->
                                {{ Form::label('conjuntoid', 'Copropiedad') }}
                                {!! Form::select('conjuntoid', [], null, ['class' => 'form-control  select2','style'=>'width: 100%','data-placeholder'=>'Seleccione la copropiedad']) !!}
                                @error('conjuntoid')
                                    <small class="text-danger">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.Row -->
                </div>
                <!-- /.Container-fluid -->
                <button class="btn btn-primary" onclick="stepper.next()">Siguiente</button>


            </div>
            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                    <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                    </div>
                </div>
                </div>
                <button class="btn btn-primary" onclick="stepper.previous()">Atras</button>
                <button type="submit" class="btn btn-primary">Registrarme</button>
            </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      Visit <a href="https://github.com/Johann-S/bs-stepper/#how-to-use-it">bs-stepper documentation</a> for more examples and information about the plugin.
    </div>
    {!! Form::close() !!}
</div>
  <!-- /.card -->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

@stop

@section('js')

    @if(session('info'))
        <script type="text/javascript">
            toastr.success("{{session('info')}}")
        </script>
    @endif

    <script type="text/javascript">
            $(document).ready(function () {
                $('.select2').select2();
                // var stepper = new Stepper($('.bs-stepper')[0])


                $("#paisid").on('change', function(e) {
                    var id = $( "#paisid" ).val();
                    var url = "{{ route('admin.entregas.persona', ":id") }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {

                            $('#ciudadid').append('<option value="">Seleccione una ciudad</option>');
                            $.each(data, function(i, res){
                                $.each(res, function(index, res1){
                                    //console.log(res);
                                    $('#ciudadid').append('<option value="'+ res1.id +'">'+ res1.personanombre +'</option>');
                                })
                            })
                        },
                        error: function(error){
                            console.log(error);
                            //$('#tipodocumentoid').val(1).change();
                            $('#ciudadid').val('');
                        }
                    });
                })

            })


            document.addEventListener('DOMContentLoaded', function () {
                window.stepper = new Stepper(document.querySelector('.bs-stepper'))
            })
    </script>
@stop
