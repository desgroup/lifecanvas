@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Stats</h3>
                    </div>
                    @if($provinceCount > 0)
                    <div class="card-block">
                        <div class="text-center">
                            <h3>Provinces Visited</h3>
                            <div class="circle" id="circles-1"></div>
                            <h1>{{ $provinceVisitedCount }}/{{ $provinceCount }}</h1>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $countryName }}</h3>
                    </div>
                    <div class="card-block">
                        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
                        <script type='text/javascript'>google.load('visualization', '1', {'packages': ['geochart']});
                            google.setOnLoadCallback(drawVisualization);

                            function drawVisualization() {var data = new google.visualization.DataTable();

                                data.addColumn('string', 'Country');
                                data.addColumn('number', 'Value');
                                data.addColumn({type:'string', role:'tooltip'});var ivalue = new Array();

                                @forEach($my_provinces as $province)
                                    data.addRows([[{v:'{{ $province->country_code }}-{{ $province->province_code }}',f:'{{ $province->province_name_en }}'},0,'{{ $province->province_name_en }}']]);
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