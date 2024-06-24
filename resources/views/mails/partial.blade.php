<!DOCTYPE html>
<html>
<head>
    <title>Budget Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            color: #A3BE84;
            font-size: 24px;
            margin-bottom: 10px;
        }
        h2 {
            color: #A3BE84;
            font-size: 20px;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 10px;
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
            background-color: #A3BE84;
            color: #fff;
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
            text-align: center;
        }
        .footer a {
            color: #A3BE84;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Site Logo">
            <h1>{{ $budgetName }} Alert</h1>
        </div>
           <p>Your budget has reached 80% of its limit.</p>
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
            Please review your expenses and adjust your budget if necessary. If you have any questions, feel free to contact us at <a href="mailto:support@sprout.com">support@sprout.com</a>.
        </p>
    </div>
</body>
</html>
