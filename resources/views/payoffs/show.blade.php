<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loans') }}
        </h2>
    </x-slot>

    @include('layouts.styles')
    @section('title', $payoff->name)



<div class="mb-4">
        <a href="{{ route('payoffs.index') }}" class="back-link">Back</a>
    </div>

<div class="payoff-container">
    <div class="payoff-header">
        
        <h1>{{ $payoff->name }}</h1>
        
    </div>

    <div class="payoff-stats ">
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
    <div class="actions-show mb-6">
        <a href="{{ route('payoffs.edit', $payoff) }}" class="edit-custom-btn">Edit</a>
        <form action="{{ route('payoffs.destroy', $payoff) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-custom-btn">Delete</button>
    </form>
    </div>
</div>

</x-app-layout>