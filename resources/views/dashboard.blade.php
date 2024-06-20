{{-- dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    <div class="dashboard-header">
        <h1 class="text-2xl font-bold">Total Balance: € {{ $totalBalance }}</h1>
        <div class="dashboard-top-right">
            <a href="{{ route('transactions.create') }}" class="dashboard-btn dashboard-btn-primary dashboard-icon-button">+</a>
            <a href="{{ route('transactions.import') }}" class="dashboard-btn dashboard-btn-primary dashboard-icon-button">
                <i class="fas fa-upload"></i>
            </a>
        </div>
    </div>

    <div class="dashboard-mb-4">
        @livewire('transaction-search', [
            'totalBalance' => $totalBalance,
            'categoryTotals' => $categoryTotals,
            'transactionData' => $transactionData,
            'balanceArr' => $balanceArr
        ])
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawInitialGraphs);

        function drawInitialGraphs() {
            const categoryTotals = @json($categoryTotals);
            const transactionData = @json($transactionData);
            const balanceArr = @json($balanceArr);
            drawPie(categoryTotals);
            drawChart(transactionData, balanceArr);
        }

        function clearFields() {
            const searchForm = document.querySelector('[x-ref=searchForm]');
            if (searchForm) {
                searchForm.reset();
            }
        }

        function drawPie(categoryTotals) {
            let data = new google.visualization.DataTable();
            data.addColumn('string', 'Category');
            data.addColumn('number', 'Amount');
            data.addRows(Object.entries(categoryTotals));

            let options = {
                title: 'Expenses by Category',
                pieHole: 0.2
            };

            let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
            chart.draw(data, options);
        }

        function drawChart(transactionData, balanceArr) {
            let data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Single transaction');
            data.addColumn('number', 'Balance');

            let rows = [];
            let maxLength = Math.max(transactionData.length, balanceArr.length);

            for (let i = 0; i < maxLength; i++) {
                let transaction = transactionData[i] || {};
                let date = transaction.date || null;
                let transactionAmount = parseFloat(transaction.amount) || null;
                let balanceValue = parseFloat(balanceArr[i]) || null;
                rows.push([date, transactionAmount, balanceValue]);
            }

            data.addRows(rows);

            let options = {
                title: 'Transaction Trend and Balance',
                curveType: 'function',
                legend: { position: 'bottom' },
                series: {
                    0: { color: '#1b9e77' },
                    1: { color: '#d95f02' },
                }
            };

            let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        document.addEventListener('livewire:load', function () {
            Livewire.on('renderGraph', function (categoryTotals, transactionData, balanceArr) {
                drawPie(categoryTotals);
                drawChart(transactionData, balanceArr);
            });
        });
    </script>
</x-app-layout>
