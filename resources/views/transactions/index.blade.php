@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

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
