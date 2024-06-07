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
<h1 class="text-3xl font-bold">Inkomsten</h1>
<div class="w-full h-full flex justify-center items-center">
    <div style="margin-left: 10px;">
        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf
            <div class="mb-4">
                <label for="action" class="block text-lg font-medium text-white">Type</label>
                <select class="form-control mt-1 block w-full text-black" id="action" name="type">
                    <option value="">Select...</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-lg font-medium text-white">Amount:</label>
                <input type="number" step="0.01" class="form-control mt-1 block w-full text-black" id="amount" name="amount" placeholder="Amount">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-white">Description:</label>
                <input type="text" class="form-control mt-1 block w-full text-black" id="description" name="description" placeholder="Description">
            </div>

            <div class="mb-4">
                <label for="banking_record_id" class="block text-lg font-medium text-white">Banking Record ID:</label>
                <input type="number" class="form-control mt-1 block w-full text-black" id="banking_record_id" name="banking_record_id" placeholder="Banking Record ID">
            </div>
            
            <div class="mb-4">
                <label for="category" class="block text-lg font-medium text-white">Category:</label>
                <select class="form-control mt-1 block w-full text-black" id="category" name="category_id">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="recipient_id" class="block text-lg font-medium text-white">Recipient ID:</label>
                <input type="number" class="form-control mt-1 block w-full text-black" id="recipient_id" name="recipient_id" placeholder="Recipient ID">
            </div>

            <form method="POST" action="/uploads" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                <div class="flex items-center justify-between">
                    <input type="file" name="my_file" id="my_file" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-300">
                </div>
                <button type="submit" class="mt-2 inline-flex justify-center py-2 px-4 border border-solid shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Upload File
                </button>
            </form>

            <div class="mb-4" id="hidden-inputs">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="valuta" value="EUR">
                <input type="hidden" name="exchange_rate" value="7">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit
            </button>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>

<h2 class="text-3xl pt-5 font-bold">Transaction history</h2>

@include('search-bar')


<div style="position: absolute; left: 15vw; margin-left: 10px;">
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
                <th>Amount</th>
                <th>Description</th>
                <th>Type</th>
                <th>Custom Category ID</th>
                <th>Recipient ID</th>
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
                <td>{{ $transaction->amount }} {{ $transaction->valuta }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->type }}</td>
                @if($transaction->custom_category_id !== null)
                    <td>{{ $transaction->custom_category_id }}</td>
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
                url: '{{ route("transactions.search") }}',
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


