@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="">All lifebytes with a place</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hidden-sm hidden-xs">
                    <hr class="mt-1 mb-1">
                    <ul class="menu-box">
                        <li class="menu-item">{{ $byteCount }} lifebytes</li>
                        <li class="menu-item"><a href="/bytes"><i class="zmdi zmdi-view-list"></i> Timeline</a></li>
                        <li class="menu-item"><a href="/bytes/images"><i class="zmdi zmdi-camera"></i> Images</a></li>
                        <li class="menu-item"><a href="/map"><i class="zmdi zmdi-pin"></i> Map</a></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                    </ul>
                    <hr class="mt-1 mb-3">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-block">
                        <div class="text-center">
                            <h3>Continents Visited</h3>
                            <div class="circle" id="circles-1"></div>
                            <h1>{{ $my_stats->cont_count }}/7</h1>
                            <h3>Countries Visited</h3>
                            <div class="circle" id="circles-2"></div>
                            <h1>{{ $my_stats->contr_count }}/249</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
                        <script type='text/javascript'>google.load('visualization', '1', {'packages': ['geochart']});
                            google.setOnLoadCallback(drawVisualization);

                            function drawVisualization() {var data = new google.visualization.DataTable();

                                data.addColumn('string', 'Country');
                                data.addColumn('number', 'Value');
                                data.addColumn({type:'string', role:'tooltip'});var ivalue = new Array();

                                @forEach($countries as $country)
                                    data.addRows([[{v:'{{ $country->id }}',f:'{{ $country->country_name_en }}'},0,'No Bytes']]);
                                    ivalue['{{ $country->id }}'] = '/bytes/create?country={{ $country->id }}';
                                @endforeach

                                @forEach($my_countries as $country)
                                    data.addRows([[{v:'{{ $country->code }}',f:'{{ $country->name }}'},1,'{{ $byteCountryCount[$country->code] . " " . str_plural('Byte', $byteCountryCount[$country->code]) }}']]);
                                    ivalue['{{ $country->code }}'] = '{{ in_array($country->code, $provincesSupported) && $byteCountryCount[$country->code] > 2 ? "/map/$country->code" : "/bytes/country/$country->code" }}';
                                @endforeach

                                var options = {
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    colorAxis:  {minValue: 0, maxValue: 1,  colors: ['#EFF7CF','#87CB12']},
                                    legend: 'none',
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    datalessRegionColor: '#f5f5f5',
                                    displayMode: 'regions',
                                    enableRegionInteractivity: 'true',
                                    resolution: 'countries',
                                    sizeAxis: {minValue: 1, maxValue:1,minSize:10,  maxSize: 10},
                                    region:'world',
                                    keepAspectRatio: true,
                                    width:800,
                                    height:500,
                                    tooltip: {textStyle: {color: '#444444'}, trigger:'focus', isHtml: false}
                                };
                                var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
                                google.visualization.events.addListener(chart, 'select', function() {
                                    var selection = chart.getSelection();
                                    if (selection.length == 1) {
                                        var selectedRow = selection[0].row;
                                        var selectedRegion = data.getValue(selectedRow, 0);
                                        if(ivalue[selectedRegion] != '') { document.location = ivalue[selectedRegion];  }
                                    }
                                });
                                chart.draw(data, options);
                            }
                        </script>
                        <div id='visualization'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('onPageCSS')
    <style>
        .menu-box {
            display: flex;
            align-items: stretch; /* Default */
            justify-content: space-around;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .menu-item {
            display: block;
            flex: 0 1 auto; /* Default */
            list-style-type: none;
        }
        .panel-body {
            padding: 1rem 2rem  !important;
        }

        .image-container {

            width: 100%;
            overflow: hidden;
            resize: both;
        }
        .image-container img {
            object-fit: contain;

            width: 100%;
        }
    </style>
@stop

@section('js_scripts')
    <script>
    $( document ).ready(function() {
        var myCircle = Circles.create({
        id: 'circles-1',
        radius: 60,
        value: {{ round( $my_stats->cont_count / 7 * 100 ,0) }},
        maxValue: 100,
        width: 8,
        text: function(value) {
            return value + '%';
        },
        colors: ['#f1f1f1', '#000'],
        duration: 600,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke circle-primary',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
        });

        var myCircle2 = Circles.create({
        id: 'circles-2',
        radius: 60,
        value: {{ round( $my_stats->contr_count / 249 * 100 ,0) }},
        maxValue: 100,
        width: 8,
        text: function(value) {
        return value + '%';
        },
        colors: ['#f1f1f1', '#000'],
        duration: 600,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke circle-primary',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
        });
    });
    </script>
@endsection