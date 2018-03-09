@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Stats</h3>
                    </div>
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
                    <div class="card-header">
                        <h3 class="card-title">World View</h3>
                    </div>
                    <div class="card-block">
                        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
                        <script type='text/javascript'>google.load('visualization', '1', {'packages': ['geochart']});
                            google.setOnLoadCallback(drawVisualization);

                            function drawVisualization() {var data = new google.visualization.DataTable();

                                data.addColumn('string', 'Country');
                                data.addColumn('number', 'Value');
                                data.addColumn({type:'string', role:'tooltip'});var ivalue = new Array();

                                @forEach($my_countries as $country)
                                    data.addRows([[{v:'{{ $country->code }}',f:'{{ $country->name }}'},0,'{{ $byteCount[$country->code] }} Bytes']]);
                                    ivalue['{{ $country->code }}'] = '{{ in_array($country->code, $provincesSupported) && $byteCount[$country->code] > 10 ? "/map/$country->code" : "/bytes/country/$country->code" }}';
                                @endforeach

                                var options = {
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    colorAxis:  {minValue: 0, maxValue: 0,  colors: ['#87CB12']},
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