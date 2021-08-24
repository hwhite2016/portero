@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Sweetalert2', 'true')
@section('plugins.Calendar', 'true')


@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')
<br>
@php
setlocale(LC_TIME, "spanish");
@endphp
<div class="card card-primary">
    {!! Form::model($zona, ['route'=>['admin.zonas.update', $zona], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}

    <div class="card-header bg-primary">
        <h1 class="card-title"><i class="far fa-calendar-alt"></i> Horario Zona Comun - {{$zona->zonanombre}}</h1>

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mb-2">
                        <a class="btn btn-warning float-right" href="{{route('admin.zonas.index')}}"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.card-body -->

    {!! Form::close() !!}
</div>
<!-- /.card -->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
<script>
    $(function () {

      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()

      var eventID = 0;
      var Calendar = FullCalendar.Calendar;
      //var Draggable = FullCalendar.Draggable;

      var calendarEl = document.getElementById('calendar');

      var calendar = new Calendar(calendarEl, {
        nowIndicator: true,
        initialView: 'timeGridWeek',
        firstDay: date.getUTCDay(),
        allDaySlot: false,
        selectable: false,
        selectMirror: false,
        locale: 'spanish',

        eventResize: function(info) {
            info.revert();
        },
        eventDragStop: function(info) {
            info.revert();
        },

        // businessHours: {daysOfWeek: [1,2,3,4,5] },
        // selectConstraint: 'businessHours',
        // eventConstraint: 'businessHours',

        validRange: {
            start: new Date(date.getTime() + (60*60*1000)),
            end: new Date(date.getTime() + (6*24*60*60*1000))
        },
        // businessHours: [ // specify an array instead
        // {
        //     daysOfWeek: [ 1, 2, 3 ], // Monday, Tuesday, Wednesday
        //     startTime: '08:00', // 8am
        //     endTime: '18:00' // 6pm
        // },
        // {
        //     daysOfWeek: [ 4, 5 ], // Thursday, Friday
        //     startTime: '10:00', // 10am
        //     endTime: '16:00' // 4pm
        // }
        // ],
        //selectConstraint: 'businessHours',
        //eventConstraint: 'businessHours',

        slotDuration: '{{$zona->zonafranjatiempo}}', // 2 hours
        slotMinTime: '{{$zona->zonahoraapertura}}', // desde
        slotMaxTime: '{{$zona->zonahoracierre}}', // hasta
        expandRows: true,

        headerToolbar: {
          left  : 'prev,next today',
          center: 'title',
          right : ''
        },
        buttonText: {
            today:    'hoy',
            month:    'mes',
            week:     'semana',
            day:      'día',
            list:     'lista'
        },
        themeSystem: 'bootstrap',

        dateClick: function(info) {
            $.ajax({
                data:
                    { start: info.dateStr,
                      zonaid: "{{ $zona->id }}",
                      zonafranjatiempo: "{{ $zona->zonafranjatiempo }}",
                      _token: "{{csrf_token()}}"
                    },
                dataType: "html",
                type: "POST",
                url: "{{route('admin.eventCalendar.store')}}",

                success: function(data) {
                    if(data) {
                        calendar.addEvent({
                            id: data,
                            title: 'Disponible',
                            start: info.dateStr,
                            //end: info.dateStr,
                            //display: 'background'
                            // backgroundColor: '#217524',
                            // borderColor: '#217524',
                            // textColor: '#FFFFFF'
                        });
                    }

                },
                error: function(error){
                    console.log(error);
                }
            });

        },

        eventSources: [
            //'/feed.php?zonaHorario={{$zonaHorario}}'

            {
                extraParams:
                    {
                      zonaid: "{{ $zona->id }}",
                      _token: "{{csrf_token()}}"
                    },
                type: "POST",
                dataType: "json",
                url: "{{route('admin.eventCalendar.index')}}"
            }
        ],

        selectOverlap: false,
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        // drop      : function(info) {
        //   if (checkbox.checked) {
        //     info.draggedEl.parentNode.removeChild(info.draggedEl);
        //   }
        // }

        eventClick: function(info) {
            //console.log(info);
            var id = info.event.id;
            var url = "{{ route('admin.eventCalendar.destroy', ":id") }}";
            url = url.replace(':id', id);
            $.ajax({
                data: { _token: "{{csrf_token()}}" },
                dataType: "html",
                type: "DELETE",
                url: url,

                success: function(data) {
                   console.log(data);
                   if(data) {
                        info.event.remove();
                   }else{
                    Swal.fire(
                        "Esta franja horaria tiene reservas asignadas.",
                        "Para poder eliminar esta franja, primero debe cancelar las reservas en la opción <a href='{{route('admin.reservas.index')}}'>reservas</a>",
                        "error"
                    )
                        //Swal.fire('Esta franja ya tiene reservas asignadas.')
                   }
                },
                error: function(error){
                    console.log(error);
                }
            });

        }

      });

      var slotDuration = calendar.getOption('slotDuration')

      calendar.render();

    })
  </script>

@stop
