@extends('layouts.custom')

@section('title', $payoff->name)

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
<div class="payoff-container">
    <div class="payoff-header">
        <a href="{{ route('payoffs.index') }}" class="btn-custom-payoff">Back</a>
        <h1>{{ $payoff->name }}</h1>
        <a href="{{ route('payoffs.edit', $payoff) }}" class="btn-custom-payoff">Edit</a>
    </div>

    <div class="payoff-stats">
        <h4>Payed off € {{ number_format($payoff->balance, 2) }} of € {{ number_format($payoff->total, 2) }}</h4>
    </div>

    <div class="mb-4">
        <h2 class="mb-4 text-lg font-weight-bold">Transactions</h2>
        @if($payoff->transaction->isEmpty())
            <p>No transactions found for this payoff.</p>
        @else
            <div class="table-responsive">
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payoff->transaction as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                <td>€ {{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->category->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <form action="{{ route('payoffs.destroy', $payoff) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-custom-payoff">Delete</button>
    </form>
</div>
@endsection
