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
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>

    <h3>Transactions:</h3>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['type'] }}</td>
                    <td>{{ $transaction['amount'] }}</td>
                    <td>{{ $transaction['date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Category Totals:</h3>
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
                    <td>{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
