@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

@section('title', $goal->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('goals.index') }}" class="link">Back</a>
    </div>

    <div class="mb-4">
        <a href="{{ route('goal_transactions.create', ['goalId' => $goal->id]) }}" class="link">Add Transaction</a>
    </div>

    <div class="mb-4">
        <p>€ {{ $goal->amount }}</p>
        <p>Deadline: {{ $goal->deadline->format('d-m-Y') }}</p>
    </div>

    <div class="mb-4">
        <h2 class="underline text-lg">Goal Progress</h2>
        <livewire:goal-progress :goal="$goal" />
    </div>

    <div class="mb-4">
        <h2 class="underline text-lg">Past transactions</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($goalTransactions as $goalTransaction)
                    <tr>
                        <td>
                            <a href="{{ route('goalTransactions.edit', $goalTransaction->id) }}">
                                {{ $goalTransaction->type }}
                            </a>
                        </td>
                        <td>{{ $goalTransaction->amount }}</td>
                        <td>{{ $goalTransaction->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
