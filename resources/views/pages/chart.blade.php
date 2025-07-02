@extends('themes.base')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('subcontent')
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

<div id="chart" style="width: 600px; height: 400px;"></div>

    




<script>
    var myChart = echarts.init(document.getElementById('chart'));
        // Draw the chart
        myChart.setOption({
        title: {
            text: 'ECharts Getting Started Example'
        },
        tooltip: {},
        xAxis: {
            data: ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']
        },
        yAxis: {},
        series: [
            {
            name: 'sales',
            type: 'bar',
            data: [5, 20, 36, 10, 10, 20]
            }
        ]
        }); 
    </script>
@endsection
