@extends('layouts.custom')

@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(
        drawPie
    );
    google.charts.setOnLoadCallback(
        drawChart
    );
    // google.charts.setOnLoadCallback(drawChart);
    let categoryTotals = @json($categoryTotals);
    let transactionData = @json($transactionData);

    console.log("category");
    console.log( categoryTotals);
    console.log("transaction");
    console.log(transactionData);
    
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
            title: 'expenses by category',
            pieHole: 0.2
        };

        let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
        chart.draw(data, options);
    }

    // function drawPie() {
    //     let data = new google.visualization.DataTable();
    //     data.addColumn('string', 'Category');
    //     data.addColumn('number', 'Amount');
    //     data.addRows([
    //         @foreach($categoryTotals as $category => $total)
    //             ['{{ $category }}', {{ $total }}],
    //         @endforeach
    //     ]);
    //     console.log(data);
    //     let options = {
    //         title: 'expenses by category',
    //         pieHole: 0.2
    //     };

    //     let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
    //     chart.draw(data, options);
    // }

    // function drawChart() {
    //     let data = new google.visualization.DataTable();
    //     let transactionData = @json($transactionData);
    //     data.addColumn('string', 'Date');
    //     data.addColumn('number', 'Amount');
    //     // Sample data (replace this with your actual data)
    //     // let transactions = [
    //     //     { month: 'Jan', type: 'income', amount: 1000 },
    //     //     { month: 'Feb', type: 'income', amount: 1200 },
    //     //     { month: 'Mar', type: 'expense', amount: 500 },
    //     //     { month: 'Apr', type: 'expense', amount: 700 },
    //     //     { month: 'Feb', type: 'income', amount: 100 }
    //     //     // Add more data rows here...
    //     // ];

    //     transactions.forEach(function(transaction) {
    //     //     console.log(transaction);
    //         let value = (transaction.type === 'income') ? transaction.amount : -transaction.amount;
    //         data.addRow([transaction.date, value]);
    //     });
    //     // Process data rows

    //     transactions.forEach(function(transaction) {
    //         let value = (transaction.type === 'income') ? transaction.amount : -transaction.amount;
    //         data.addRow([transaction.month, value]);
    //     });
    //     let options = {
    //         title: 'Transaction Trend',
    //         curveType: 'function',
    //         legend: { position: 'bottom' }
    //     };
    //     let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    //     chart.draw(data, options);
    // }

    function drawChart() {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Amount');
        // Retrieve transaction data passed from the controller
        let transactions = @json($transactionData);
        transactions.forEach(function(transaction) {
            let value = (transaction.type === 'income') ? transaction.amount : -transaction.amount;
            data.addRow([transaction.date, value]);
        });
        let options = {
            title: 'Transaction Trend',
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
@endsection

@section('content')
<h2 class="text-3xl pt-5 font-bold">Graphs</h2>
<!-- <p>circle graph</p> -->
<div id="pieChart"></div>
<div id="chart_div" style="width: 100%; height: 400px;"></div>
@endsection
