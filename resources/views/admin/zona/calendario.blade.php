@extends('adminlte::page')

@section('title', 'Zonas Comunes')

@section('plugins.Select2', 'true')
@section('plugins.Sweetalert2', 'true')
@section('plugins.Calendar', 'true')


@section('content_header')
    {{-- <h1 class="ml-3">Crear zona</h1> --}}
@stop

@section('content')

<div class="card card-primary">
    {!! Form::model($zona, ['route'=>['admin.zonas.update', $zona], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @csrf
    {{-- @method('POST') --}}
    <div class="card-header bg-primary">
        <h1 class="card-title"><i class="far fa-calendar-alt"></i> HORARIO ZONA COMUN - {{$zona->zonanombre}}</h1>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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

        $.ajax({
            type: "GET",
            dataType: "json",
            _token: "{{csrf_token()}}",
            url: "{{route('admin.zonas.eventos')}}",
            success: function(data) {

                $.each(data, function(i, res){
                        console.log(res[0]);
                        hw = "{ id: 1, title: 'Disponible', start: '2021-06-23T10:00:00', end: '2021-06-23T11:30:00' },";
                })
            },
            error: function(error){
                console.log(error);
            }
        });


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
        nowIndicator: false,
        initialView: 'timeGridWeek',
        firstDay: date.getUTCDay()-1,
        allDaySlot: false,
        selectable: true,
        selectMirror: false,

        // businessHours: {daysOfWeek: [1,2,3,4,5] },
        // selectConstraint: 'businessHours',
        // eventConstraint: 'businessHours',

        validRange: {
            start: new Date(date.getTime() + (60*60*1000)),
            end: new Date(date.getTime() + (15*24*60*60*1000))
        },
        businessHours: [ // specify an array instead
        {
            daysOfWeek: [ 1, 2, 3 ], // Monday, Tuesday, Wednesday
            startTime: '08:00', // 8am
            endTime: '18:00' // 6pm
        },
        {
            daysOfWeek: [ 4, 5 ], // Thursday, Friday
            startTime: '10:00', // 10am
            endTime: '16:00' // 4pm
        }
        ],
        selectConstraint: 'businessHours',
        eventConstraint: 'businessHours',

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
        //Random default events

        select: function(info) {
            calendar.addEvent({
                id: eventID + 1,
                title: 'Disponible',
                start: info.startStr,
                end: info.endStr,


                //display: 'background'
                // backgroundColor: '#217524',
                // borderColor: '#217524',
                // textColor: '#FFFFFF'
            });
            eventID++;
        },

        // dateClick: function(info) {
        //     calendar.addEvent({
        //         id: eventID + 1,
        //         title: 'Disponible',
        //         start: info.dateStr,

        //         //display: 'background'
        //         // backgroundColor: '#217524',
        //         // borderColor: '#217524',
        //         // textColor: '#FFFFFF'
        //     });
        //     eventID++;
        // },

        eventSources: [
            '/feed.php'
        ],

        selectOverlap: true,
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        // drop      : function(info) {
        //   if (checkbox.checked) {
        //     info.draggedEl.parentNode.removeChild(info.draggedEl);
        //   }
        // }

        eventClick: function(info) {
            info.event.remove();
        }

      });

      var slotDuration = calendar.getOption('slotDuration')

      calendar.render();
      // $('#calendar').fullCalendar()

    })
  </script>

@stop
