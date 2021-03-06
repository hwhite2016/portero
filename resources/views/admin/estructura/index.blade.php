@extends('adminlte::page')

@section('title', 'Organigrama')

@section('plugins.Select2', 'true')

@section('content_header')
    {{-- <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item text-primary"><a href="{{route('admin.reservas.index')}}">Organigrama</a></li>
            <li class="breadcrumb-item active">Mi Conjunto</li>
            </ol>
        </div>
        </div>
    </div> --}}
@stop

@section('content')
<br>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <label class="card-title text-primary">Estructura Orgánica | {{$conjunto->conjuntonombre}}</label>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {{-- <div id="chart-container"></div> --}}

                <figure class="highcharts-figure">
                    <div id="container"></div>

                </figure>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <label class="card-title text-primary">Detalle de la Estructura</label>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div id="accordion">
                    @foreach ($colaboradores as $colaborador)
                    <div class="card card-light">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$colaborador->id}}">
                                    <label>{{ $colaborador->organonombre }}</label>
                                    <i class="fas fa-chevron-right float-right"></i>
                                </a>

                            </h4>

                        </div>
                      <div id="collapse{{$colaborador->id}}" class="collapse {{$colaborador->organonivel == 2 ? 'show' : ''}}" data-parent="#accordion">
                        <div class="card-body">
                            <p>
                                @if($colaborador->organocorreo)
                                    <span class="text-muted"><i class="far fa-envelope mr-1"></i>
                                        {{ $colaborador->organocorreo }}
                                    </span>
                                @endif
                                @if($colaborador->organocelular)
                                    <br><span class="text-muted"><i class="fas fa-mobile-alt mr-1"></i> {{ $colaborador->organocelular }}
                                        @if($colaborador->organotelefono)
                                            <i class="fas fa-phone-volume ml-3 mr-1"></i> {{ $colaborador->organotelefono }}
                                        @endif
                                    </span>
                                @endif

                                @if($colaborador->organopqr)
                                    <br><a class="text-primary" href="{{route('admin.pqrs.create')}}"><u>Crear PQR</u> <i class="fas fa-long-arrow-alt-right"></i></a>
                                @endif

                            </p>
                            Miembro(s):
                            <p class="text-muted">
                                @php
                                    $miembros = json_decode($colaborador->miembros, true);
                                @endphp

                                @foreach($miembros as $miembro => $valor)
                                    <i class="fas fa-caret-right"></i> {{$miembro}}
                                    @if($valor)
                                        <small class="font-italic text-primary ml-1">({{$valor}})</small>
                                    @endif
                                    <br>
                                @endforeach
                            </p>
                        </div>
                      </div>
                    </div>
                    @endforeach

                  </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
</div>


@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')


    <style type="text/css">

        #container {
            min-width: 300px;
            max-width: 1200px;
            margin: 1em auto;

        }

        #container h4 {
            text-transform: none;
            font-size: 14px;
            font-weight: normal;
        }
        #container p {
            font-size: 13px;
            line-height: 16px;
        }

        @media screen and (max-width: 600px) {
            #container h4 {
                font-size: 2.3vw;
                line-height: 3vw;
            }
            #container p {
                font-size: 2.3vw;
                line-height: 3vw;
            }
        }

        #csv {
            display: none;
        }


    </style>


@stop

@section('js')

    {{-- <script src="/js/jquery.orgchart.js"></script> --}}

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/sankey.js"></script>
    <script src="https://code.highcharts.com/modules/organization.js"></script>





    <script type="text/javascript">

        Highcharts.chart('container', {

        chart: {
            height: 600,
            inverted: true
        },

        title: {
            text: ''
        },

        series: [{
            type: 'organization',
            name: '{{$conjunto->conjuntonombre}}',
            keys: ['from', 'to'],
            data: [
                ['Asamblea', 'Revisor'],
                ['Asamblea', 'Consejo'],
                ['Consejo', 'Comite'],
                ['Consejo', 'Administrador'],
                ['Administrador', 'Contador'],
                ['Administrador', 'Empleados'],
                ['Administrador', 'Contratistas']
            ],
            levels: [{
                level: 0,
                color: '#359154',
                dataLabels: {
                    color: 'white'
                },
                height: 25
            }, {
                level: 1,
                color: 'silver',
                dataLabels: {
                    color: 'black'
                },
                height: 25
            }, {
                level: 2,
                color: '#980104'
            }, {
                level: 4,
                color: '#359154'
            }],
            nodes: [{
                id: 'Asamblea',
                name: 'Asamblea General de propietarios',
                title: '<a target="_blank" class="text-light" href="https://www.minvivienda.gov.co/sites/default/files/2020-07/cartilla-propiedad-horizontal-web.pdf"><u>Ley 675 de 2001</u></a>'
            }, {
                id: 'Revisor',
                name: 'Revisor Fiscal',
                //image: 'https://ui-avatars.com/api?name=R F&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                //column: 1,
                offset: '60%'
            }, {
                id: 'Consejo',
                name: 'Consejo de Administración',
                //title: '{{$conjunto->conjuntocorreoconsejo}}',
                //image: 'https://ui-avatars.com/api?name=C A&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                color: '#359154',
                dataLabels: {
                    color: 'white'
                },
                column: 2,
            }, {
                id: 'Comite',
                name: 'Comite Convivencia',
                //title: '{{$conjunto->conjuntocorreocomite}}',
                //image: 'https://ui-avatars.com/api?name=C C&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                color: 'silver',
                dataLabels: {
                    color: 'black'
                },
                //column: 3,
                offset: '60%'
            }, {
                id: 'Administrador',
                name: 'Administración',
                //title: '{{$conjunto->conjuntocorreo}}',
                //description: '{{$conjunto->conjuntocelular}}',
                //image: 'https://ui-avatars.com/api?name=A&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                column: 4,
                height: 70
                //layout: 'hanging'
            }, {
                id: 'Contador',
                name: 'Contador',
                //image: 'https://ui-avatars.com/api?name=C&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                column: 5,
                color: 'silver',
                dataLabels: {
                    color: 'black'
                },
                offset: '60%'
            }, {
                id: 'Empleados',
                name: 'Empleados',
                //image: 'https://ui-avatars.com/api?name=E&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                column: 6,
                layout: 'hanging'
            }, {
                id: 'Contratistas',
                //image: 'https://ui-avatars.com/api?name=C&color=5F91E2&background=EBF4FF&bold=true&rounded=true',
                column: 6,
                layout: 'hanging'
            }],
            colorByPoint: false,
            color: '#007ad0',
            dataLabels: {
                color: 'white',
                nodeFormatter: function () {
                    // Call the default renderer
                    var html = Highcharts.defaultOptions
                        .plotOptions
                        .organization
                        .dataLabels
                        .nodeFormatter
                        .call(this);

                    // Do some modification
                    html = html.replace(
                        '<h4 style="',
                        '<h4 style="font-style: normal;'
                    );
                    return html;
                }
            },
            borderColor: 'white',
            nodeWidth: 55
        }],
        tooltip: {
            outside: true
        },
        exporting: {
            allowHTML: true,
            sourceWidth: 800,
            sourceHeight: 600
        }

        });

    </script>



@stop
