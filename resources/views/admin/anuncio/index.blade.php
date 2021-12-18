@extends('adminlte::page')

@section('title', 'Comunicados')

@section('plugins.Select2', 'true')
@section('plugins.Toastr', 'true')
@section('plugins.Sweetalert2', 'true')

@section('content_header')
    <div class='alert alert-default-primary alert-dismissible fade show' role='alert'>
        <i class="fas fa-info-circle"></i>&nbsp;
        Los comunicados que se envien a los residentes de las unidades de un bloque, o a los residentes de las unidades de todo un conjunto, solo seran recibidas por aquellos residentes cuyas unidades hayan sido verificadas por la administración.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
@stop

@section('content')
    @livewire('admin.anuncios-index')
@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')

    <style type="text/css">
      tr.group,
      tr.group:hover {
          background-color: #ddd !important;
      }
      .c-pointer {
            cursor: pointer;
      }
      .pagination {
            display: -ms-flexbox;
            flex-wrap: wrap;
            display: flex;
            padding-left: 20;
            list-style: none;
            border-radius: 0.25rem;
        }
    </style>
@stop

@section('js')

   @if(session('info'))
    <script type="text/javascript">
        toastr.success("{{session('info')}}")
    </script>
   @endif
   @if(session('error'))
    <script type="text/javascript">
        toastr.error("{{session('error')}}")
    </script>
   @endif

   <script>
      $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()

            $('.enviar').on('click', function() {
                $(this).prop('disabled',true);
                $(this).text('Enviando..');
            });
      });

      $('.frm_delete').submit(function(e){
          e.preventDefault();

          Swal.fire({
            title: 'Esta usted seguro de eliminar este registro?',
            text: "Esta accion no se podra deshacer!",
            icon: 'warning',
            progressBar: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          })
      });

   </script>
@stop
