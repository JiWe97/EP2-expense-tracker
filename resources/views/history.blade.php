@extends('layouts.custom')

@section('content')
<h2 class="text-3xl pt-5 font-bold">Transaction history</h2>

@include('search-bar')

<div style="margin-left: 10px;">
    @if(isset($query))
            <h3 class="text-2xl font-semibold">Search Results for "{{ $query }}"</h3>
    @endif
    @if($transactions->isEmpty())
        <p>No transactions found.</p>
    @else
        @foreach ($transactions as $transaction)
            <div class="transaction-item mb-4 p-4 bg-gray-100 rounded shadow">
                <p><strong>User:</strong> {{ $transaction->user_id }}</p>
                <p><strong>Amount:</strong> {{ $transaction->amount }} {{ $transaction->valuta }}</p>
                <p><strong>Description:</strong> {{ $transaction->description }}</p>
                <p><strong>Type:</strong> {{ $transaction->type }}</p>
                @if($transaction->custom_category_id !== null)
                    <p><strong>Custom Category ID:</strong> {{ $transaction->custom_category_id }}</p>
                @endif
                @if($transaction->recipient_id !== null)
                    <p><strong>Recipient ID:</strong> {{ $transaction->recipient_id }}</p>
                @endif
                @if($transaction->exchange_rate !== null)
                    <p><strong>Exchange Rate:</strong> {{ $transaction->exchange_rate }}</p>
                @endif
                @if($transaction->warranty !== null)
                    <p><strong>Warranty:</strong> {{ $transaction->warranty }}</p>
                @endif
                @if($transaction->warranty_date !== null)
                    <p><strong>Warranty Date:</strong> {{ $transaction->warranty_date }}</p>
                @endif
                <p><strong>Banking Record ID:</strong> {{ $transaction->banking_record_id }}</p>
                <p><strong>Created At:</strong> {{ $transaction->created_at }}</p>
                <p><strong>Updated At:</strong> {{ $transaction->updated_at }}</p>
            </div>
        @endforeach
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

