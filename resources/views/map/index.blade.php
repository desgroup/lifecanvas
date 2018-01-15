@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Stats</h3>
                </div>
                <div class="panel-body">
                    <h1>{{ $my_stats->cont_count }}/7</h1>
                    Continents Visited ({{ round($my_stats->cont_count/7*100) }}%)<br>
                    <h1>{{ $my_stats->count_count }}/249</h1>
                    Countries Visited ({{ round($my_stats->count_count/249*100) }}%)
                </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">World View</h3>
                    </div>
                    <div class="panel-body">
                        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
                        <script type='text/javascript'>google.load('visualization', '1', {'packages': ['geochart']});
                            google.setOnLoadCallback(drawVisualization);

                            function drawVisualization() {var data = new google.visualization.DataTable();

                                data.addColumn('string', 'Country');
                                data.addColumn('number', 'Value');
                                data.addColumn({type:'string', role:'tooltip'});var ivalue = new Array();

                                @forEach($my_countries as $country)
                                    data.addRows([[{v:'{{ $country->code }}',f:'{{ $country->name }}'},0,'{{ $country->name }}']]);
                                    ivalue['{{ $country->code }}'] = '/map/{{ $country->code }}';
                                @endforeach

                                var options = {
                                    backgroundColor: {fill:'#FFFFFF',stroke:'#FFFFFF' ,strokeWidth:0 },
                                    colorAxis:  {minValue: 0, maxValue: 0,  colors: ['#6699CC']},
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
