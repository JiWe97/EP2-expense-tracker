@extends('layouts.custom')

@section('styles')
    <style>
        /* body.table{
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;

        } */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            /* position: absolute;
            left: 100px; */
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .transaction-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .transaction-table th, .transaction-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .transaction-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #f2f2f2;
            color: black;
        }
        .transaction-table tr:hover {
            background-color: #f1f1f1;
        }
        .transaction-table .conditional {
            background-color: #eaf3ff;
        }
    </style>
@endsection

@section('content')
<div class="mb-4">
    <h1 class="text-xl pt-5 font-bold">Manual Entry</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-5">Add Transaction</a>
</div>

<div class="mb-4">
    <h1 class="text-xl pt-5 font-bold">Upload Bank Statement</h1>
        <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".csv">
            <button class="btn btn-primary" type="submit">Upload</button>
        </form>
</div>

<div class="mb-4">
    <h2 class="text-3xl pt-5 font-bold">Transaction history</h2>

    @include('search-bar')


    <div class="justify-center flex items-center">
        @if(isset($query))
                <h3 class="text-2xl font-semibold">Search Results for "{{ $query }}"</h3>
        @endif
        @if($transactions->isEmpty())
            <td>No transactions found.</td>
        @else
        <div class="table-responsive">
            <table class="table table-dark table-sm">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Recipient</th>
                    <th>Exchange Rate</th>
                    <th>Warranty</th>
                    <th>Warranty Date</th>
                    <th>Bank</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            @foreach ($transactions as $transaction)
                <?php //echo $transaction; ?>
                <tbody class="table-group-divider">
                <div class="transaction-item mb-4 td-4 bg-gray-100 rounded shadow">
                    <th scope="row">{{ $transaction->user_id }}</th>
                    <td>{{ $transaction->date }}</td>
                    <td><a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">{{ $transaction->amount }} {{ $transaction->valuta }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->type }}</td>
                    @if($transaction->category_id !== null)
                        <td>{{ $transaction->category_id }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($transaction->recipient_id !== null)
                        <td>{{ $transaction->recipient_id }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($transaction->exchange_rate !== null)
                        <td>{{ $transaction->exchange_rate }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($transaction->warranty !== null)
                        <td> {{ $transaction->warranty }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($transaction->warranty_date !== null)
                        <td>{{ $transaction->warranty_date }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $transaction->banking_record_id }}</td>
                    @if($transaction->created_at !== null)
                    <td>{{ $transaction->created_at }}</td>
                    @else
                        <td></td>
                    @endif
                    @if($transaction->updated_at !== null)
                    <td>{{ $transaction->updated_at }}</td>
                    @else
                        <td></td>
                    @endif
                </div>
                </tbody>
            @endforeach
            </table>
        </div>
        @endif
    </div>

    <div class="pagination mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault();
            var query = $('input[name="query"]').val();
            
            // Check if the search query is empty
            if(query.trim() === "") {
                return false;
            }

            $.ajax({
                url: '{{ route("transactions.index") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    query: query
                },
                success: function(response) {
                    $('#transactions-container').html(response.transactions);
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });
    });
</script>
@endsection

