@extends('layouts.custom')

@section('title', $payoff->name)

@section('styles')
<style>
    .display-4 {
        font-size: 2.5rem;
        font-weight: 300;
        line-height: 1.2;
    }
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .font-weight-bold {
        font-weight: bold;
    }
    .container {
        max-width: 1200px;
    }
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')
<div class="container form-container">
    <div class="mb-4">
        <a href="{{ route('payoffs.index') }}" class="btn btn-secondary btn-lg">Back</a>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('payoffs.edit', $payoff) }}" class="btn btn-primary btn-lg">Edit</a>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <h4>Total: <span class="font-weight-bold">€ {{ $payoff->total }}</span></h4>
            <h4>Balance: <span class="font-weight-bold">€ {{ $payoff->balance }}</span></h4>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="mb-4 text-lg font-weight-bold">Transactions</h2>
        @if($payoff->transaction->isEmpty())
            <p>No transactions found for this payoff.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
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
                                <td>{{ $transaction->amount }}</td>
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
    {{-- delete form --}}
    <form action="{{ route('payoffs.destroy', $payoff) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-lg">Delete</button>
    </form>
</div>
@endsection
