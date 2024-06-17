<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        img{
            max-width: 500px;
        }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <!-- <h2>Graphs</h2> -->
    <div>
        <img src="{{ $transactionChartUrl }}" alt="Transaction Trend Chart">
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['date'] }}</td>
                    <td>{{ $transaction['amount'] }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryTotals as $category => $total)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ $total }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
