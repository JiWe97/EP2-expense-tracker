@extends('layouts.custom')

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
    <div class="goal-detail-container">
       <div class="goal-detail-header">
            <a href="{{ route('goals.index') }}" class="goal-detail-link">Back</a>
            <h1 class="goal-detail-title">{{ $goal->name }}</h1>
            <a href="{{ route('goal_transactions.create', ['goalId' => $goal->id]) }}" class="goal-detail-button">Add Transaction</a>
        </div>

        <div class="goal-detail-info">
            <p>Deadline: {{ $goal->deadline->format('d-m-Y') }}</p>
        
        </div>

        <div class="goal-progress-container">
            <livewire:goal-progress :goal="$goal" />
        </div>
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($goalTransactions as $goalTransaction)
                    <tr onclick="window.location='{{ route('goal_transactions.edit', $goalTransaction->id) }}'">
                        <td>{{ $goalTransaction->amount }}</td>
                        <td>{{ $goalTransaction->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
