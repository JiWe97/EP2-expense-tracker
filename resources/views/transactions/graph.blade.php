@extends('layouts.app')

@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);

    function drawTable() {
        console.log('Drawing table...');

        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Amount');
        data.addColumn('string', 'Date'); 

        // Set table options
        let options = {
            allowHtml: true,
            showRowNumber: true,
            width: '100%',
            height: '100%'
        };

        // Get transactions data from PHP
        let transactions = @json($transactions);
        console.log('Transactions:', transactions);

        // Process transactions data into rows for DataTable
        let rows = transactions.map(transaction => [
            transaction.name, 
            {v: transaction.amount, f: '$' + transaction.amount.toLocaleString()},
            transaction.date
        ]);

        data.addRows(rows);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
    }
</script>
@endsection

@section('content')
<h2 class="text-3xl pt-5 font-bold">Graphs</h2>

<div id="table_div"></div>

@endsection
