@extends('layouts.custom')

@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPie);
    google.charts.setOnLoadCallback(drawChart);

    function drawPie() {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Amount');
        data.addRows([
            @foreach($categoryTotals as $category => $total)
                ['{{ $category }}', {{ $total }}],
            @endforeach
        ]);
        console.log(data);
        let options = {
            title: 'Transaction Amounts by Category',
            pieHole: 0.2
        };

        let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
        chart.draw(data, options);
    }

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Amount');
        // Sample data (replace this with your actual data)
        var transactions = [
            { month: 'Jan', type: 'income', amount: 1000 },
            { month: 'Feb', type: 'income', amount: 1200 },
            { month: 'Mar', type: 'expense', amount: 500 },
            { month: 'Apr', type: 'expense', amount: 700 },
            // Add more data rows here...
        ];
        // Process data rows
        transactions.forEach(function(transaction) {
            var value = (transaction.type === 'income') ? transaction.amount : -transaction.amount;
            data.addRow([transaction.month, value]);
        });
        var options = {
            title: 'Transaction Trend',
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
@endsection

@section('content')
<h2 class="text-3xl pt-5 font-bold">Graphs</h2>
<p>circle graph</p>
<div id="pieChart"></div>
<div id="chart_div" style="width: 100%; height: 400px;"></div>
@endsection
