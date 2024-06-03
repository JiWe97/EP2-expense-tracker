<div class="mb-4">
@foreach ($transactions as $transaction)
    <div class="transaction-card">
        <a href="{{ route('transactions', $transaction->id) }}">
            <h3>{{ $transaction->amount }}</h3>
            <p>{{ $transaction->category->name }}</p>
        </a>
    </div>
    <x-transaction-details :transaction="$transaction" />
@endforeach
</div>

<h1>Dashboard</h1>

@if (count($transactions) > 0)
    <div class="transactions-container">
        @foreach ($transactions as $transaction)
            <x-transaction-history :transaction="$transaction" />
        @endforeach
    </div>
@else
    <p>No recent transactions found.</p>
@endif

<x-transaction-history :transaction="$transaction">
    <h3>{{ $transaction->amount }}</h3>
    <p>{{ $transaction->category->name ?? 'Uncategorized' }}</p>
    <p>{{ $transaction->created_at->format('Y-m-d') }}</p>
</x-transaction-history>