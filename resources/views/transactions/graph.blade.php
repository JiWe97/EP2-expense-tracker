@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);

    function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Amount');
        data.addColumn('string', 'Date'); // Adjust columns based on your transaction data structure

        // Get transactions data from PHP
        var transactions = @json($transactions);

        // Process transactions data into rows for DataTable
        var rows = transactions.map(transaction => [
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

<div id="table_div">

</div>
@endsection