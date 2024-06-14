@extends('layouts.custom')

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
            @foreach($goal_transactions as $goal_transaction)
                <tr>
                    <td><a href="{{ route('goal_transactions.edit', $goal_transaction->id) }}">{{ $goal_transaction->type }}</a></td>
                    <td>{{ $goal_transaction->amount }}</td>
                    <td>{{ $goal_transaction->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
