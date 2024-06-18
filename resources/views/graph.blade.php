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

    // console.log("category");
    // console.log( categoryTotals);
    // console.log("transaction");
    // console.log(transactionData);
    
    function drawPie() {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Amount');
        data.addRows([
            @foreach($categoryTotals as $category => $total)
                ['{{ $category }}', {{ $total }}],
            @endforeach
        ]);
        // console.log(data);
        let options = {
            title: 'expenses by category',
            pieHole: 0.2
        };

        let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
        chart.draw(data, options);
    }

    function drawChart() {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Index');
        data.addColumn('number', 'Single transaction');
        data.addColumn('number', 'Balance'); // Add a new column for balance

        // Retrieve transaction data and balance data passed from the controller
        let transactions = @json($transactionData);
        let balances = @json($balanceArr);

        let rows = [];
        let maxLength = Math.max(transactions.length, balances.length);

        // Populate rows with transactions and balances
        for (let i = 0; i < maxLength; i++) {
            let transactionAmount = i < transactions.length ? parseFloat(transactions[i].amount) : null;
            let date = i < transactions.length ? transactions[i].date : null;
            let balanceValue = i < balances.length ? parseFloat(balances[i]) : null;
            rows.push([date, transactionAmount, balanceValue]);
        }

        data.addRows(rows);

        let options = {
            title: 'Transaction Trend and Balance',
            curveType: 'function',
            legend: { position: 'bottom' },
            series: {
                0: { color: '#1b9e77' }, // Transactions
                1: { color: '#d95f02' }, // Balance
            }
        };

        let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }


    // function drawChart() {
    //     let data = new google.visualization.DataTable();
    //     data.addColumn('string', 'Date');
    //     data.addColumn('number', 'Amount');
    //     data.addColumn('number', 'Balance'); // Add a new column for balance

    //     // Retrieve transaction data and balance data passed from the controller
    //     let transactions = @json($transactionData);
    //     let balances = @json($balanceArr);
    //     console.log(balances);
    //     let transactionIndex = 0;
    //     let balanceIndex = 0;
    //     let rows = [];

    //     // Merge transactions and balance history
    //     while (transactionIndex < transactions.length || balanceIndex < balances.length) {
    //         let transactionDate = transactionIndex < transactions.length ? transactions[transactionIndex].date : null;
    //         let balanceDate = balanceIndex < balances.length ? balances[balanceIndex].date : null;

    //         if (transactionDate === balanceDate) {
    //             rows.push([transactionDate, transactions[transactionIndex].amount, balances[balanceIndex].balance]);
    //             transactionIndex++;
    //             balanceIndex++;
    //         } else if (!transactionDate || (balanceDate && balanceDate < transactionDate)) {
    //             rows.push([balanceDate, null, balances[balanceIndex].balance]);
    //             balanceIndex++;
    //         } else {
    //             rows.push([transactionDate, transactions[transactionIndex].amount, null]);
    //             transactionIndex++;
    //         }
    //     }

    //     data.addRows(rows);

    //     let options = {
    //         title: 'Transaction Trend',
    //         curveType: 'function',
    //         legend: { position: 'bottom' },
    //         series: {
    //             0: { color: '#1b9e77' },
    //             1: { color: '#d95f02' },
    //         }
    //     };

    //     let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    //     chart.draw(data, options);
    // }
</script>
@endsection

@section('content')
<h2 class="text-3xl pt-5 font-bold">Graphs</h2>
<!-- <p>circle graph</p> -->
<div id="pieChart"></div>
<div id="chart_div" style="width: 100%; height: 400px;"></div>
@endsection
