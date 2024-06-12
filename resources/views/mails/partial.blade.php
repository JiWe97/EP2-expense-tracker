<!DOCTYPE html>
<html>
<head>
    <title>Budget Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            color: #d9534f;
        }
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .transaction-table th, .transaction-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .transaction-table th {
            background-color: #f4f4f4;
        }
        .transaction-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .transaction-table tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>{{ $budgetName }} Alert</h1>
    <p>Your budget for {{ $budgetCategory }} has reached 80% of its limit.</p>
    <p><strong>Budget Amount:</strong> €{{ $budgetAmount }}</p>
    <h2>Recent Transactions</h2>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->description }}</td>
                    <td>€{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->category->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="footer">
        Please review your expenses and adjust your budget if necessary. If you have any questions, feel free to contact us at <a href="mailto:support@example.com">support@example.com</a>.
    </p>
</body>
</html>
