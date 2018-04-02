@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="">{{ $country->country_name_en}} lifebytes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hidden-sm hidden-xs">
                    <hr class="mt-1 mb-1">
                    <ul class="menu-box">
                        <li class="menu-item">{{ $byteCount }} lifebytes</li>
                        <li class="menu-item"><a href="/bytes/country/{{ $country_code }}"><i class="zmdi zmdi-view-list"></i> Timeline</a></li>
                        <li class="menu-item"><a href="/bytes/images/country/{{ $country_code }}"><i class="zmdi zmdi-camera"></i> Images</a></li>
                        <li class="menu-item"><a href="/map/{{ $country_code }}"><i class="zmdi zmdi-pin"></i> Map</a></li>
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
                    @if($provinceCount > 0)
                    <div class="card-block">
                        <div class="text-center">
                            <h3>{{ $country->province_label_en }} Visited</h3>
                            <div class="circle" id="circles-1"></div>
                            <h1>{{ $provinceVisitedCount }}/{{ $provinceCount }}</h1>
                        </div>
                    </div>
                    @endif
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

                                @forEach($my_provinces as $province)
                                    data.addRows([[{v:'{{ $province->country_code }}-{{ $province->province_code }}',f:'{{ $province->province_name_en }}'},0,'{{ $byteProvinceCount[$province->province_code] . " " . str_plural('Byte', $byteProvinceCount[$province->province_code]) }}']]);
                                    ivalue['{{ $province->country_code }}-{{ $province->province_code }}'] = '/bytes';
                                @endforeach

                                var options = {
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    colorAxis:  {minValue: 0, maxValue: 0,  colors: ['#87CB12']},
                                    legend: 'none',
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    datalessRegionColor: '#f5f5f5',
                                    displayMode: 'regions',
                                    enableRegionInteractivity: 'true',
                                    resolution: 'provinces',
                                    sizeAxis: {minValue: 1, maxValue:1,minSize:10,  maxSize: 10},
                                    region:'{{ $country_code }}',
                                    keepAspectRatio: true,
                                    width:600,
                                    height:400,
                                    tooltip: {textStyle: {color: '#444444'}, trigger:'focus', isHtml: false}
                                };
                                var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
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
                value: {{ round ($provinceVisitedCount / $provinceCount * 100 , 0) }},
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