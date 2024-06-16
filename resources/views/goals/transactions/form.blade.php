@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

@section('title', isset($goal_transaction) ? 'Edit' : 'Add')

@section('content')
    <form method="POST" action="{{ isset($goal_transaction) ? route('goal_transactions.update', $goal_transaction->id) : route('goal_transactions.store') }}">
        @csrf
        @if (isset($goal_transaction))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="type">Add or Remove?</label>
            <select name="type" id="type">
                <option value="Add" {{ isset($goal_transaction) && $goal_transaction->type === 'Add' ? 'selected' : '' }}>Add</option>
                <option value="Remove" {{ isset($goal_transaction) && $goal_transaction->type === 'Remove' ? 'selected' : '' }}>Remove</option>
            </select>
            @error('type')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ $goal_transaction->amount ?? old('amount') }}">
            @error('amount')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="goal_id" value="{{ $goal->id ?? '' }}">

        <div class="flex items-center gap-2">
            <button type="submit" class="btn">
                @isset($goal_transaction)
                    Update Transaction
                @else
                    Add Transaction
                @endisset
            </button>
            <a href="{{ isset($goal) ? route('goals.show', $goal->id) : route('goals.index') }}" class="link">Cancel</a>
        </div>
    </form>

    @isset($goal_transaction)
        <form action="{{ route('goal_transactions.destroy', $goal_transaction->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete</button>
        </form>
    @endisset
@endsection
