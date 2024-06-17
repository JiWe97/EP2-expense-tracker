@extends('layouts.custom')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e0e0e0;
        }

        .transaction-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .transaction-table th, .transaction-table td {
            border: none;
            padding: 12px 15px;
        }

        .transaction-table th {
            background-color: #f7f7f7;
            font-weight: bold;
            color: #333;
        }

        .transaction-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-table tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #555;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #333;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #333;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #f1f1f1;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            width: 80%;
            max-width: 500px;
            margin: auto;
        }

        .modal img {
            max-width: 100%;
            height: auto;
        }

        .modal:target {
            display: flex;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
@endsection


@section('content')
<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Current balance</h1>
    @foreach ($bankingRecords as $bankingRecord)
        <p>{{ $bankingRecord->name }}: € {{ $bankingRecord->balance }}</p>
        <p>Total saved: € {{ $totalAmountSaved }}</p>
        <p>Total without savings: € {{ $bankingRecord->balance - $totalAmountSaved }}</p>
    @endforeach
</div>

<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Manual Entry</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-5">Add Transaction</a>
</div>

<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Upload Bank Statement</h1>
    <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".csv" class="form-control">
        <button class="btn btn-primary mt-2" type="submit">Upload</button>
    </form>
</div>

<div class="mb-4">
    <h2 class="text-2xl pt-5 font-bold">Transaction history</h2>

    @include('search-bar')

    <div class="justify-center flex items-center">
        @if (isset($query))
            <h3 class="text-2xl font-semibold">Search Results for "{{ $query }}"</h3>
        @endif

        @if ($transactions->isEmpty())
            <p class="text-center">No transactions found.</p>
        @else
            <div class="table-responsive">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Bank</th>
                            <th>Attachment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user_id }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td><a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">{{ $transaction->amount }} {{ $transaction->valuta }}</a></td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->category_id ?? '' }}</td>
                                <td>{{ $transaction->banking_record_id }}</td>
                                <td>
                                    @if ($transaction->attachments->isNotEmpty())
                                        @foreach ($transaction->attachments as $attachment)
                                            <a href="#modal-{{ $attachment->id }}">View Attachment</a>

                                            <!-- Modal Structure -->
                                            <div id="modal-{{ $attachment->id }}" class="modal">
                                                <div class="modal-content">
                                                    <a href="#" class="close">&times;</a>
                                                    <img src="{{ asset('storage/' . $attachment->picture) }}" alt="Attachment">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        No Attachment
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="pagination mt-4">
        {{ $transactions->links() }}
    </div>

    <div class="container">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('pdf') }}" class="btn btn-primary">PDF</a>
            <a href="{{ route('graph') }}" class="btn btn-secondary">See Graph</a>
        </div>
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
            if (query.trim() === "") {
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
