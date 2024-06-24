<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Goals') }}
        </h2>
    </x-slot>

    @section('title', isset($goal_transaction) ? 'Edit Transaction' : 'Add Transaction')
    @include('layouts.styles')

    <div class="goal-form-container">
    <h1 class="text-center">{{ isset($goal_transaction) ? 'Edit Transaction' : 'Add Transaction' }}</h1>
    <form method="POST" action="{{ isset($goal_transaction) ? route('goal_transactions.update', $goal_transaction->id) : route('goal_transactions.store') }}">
        @csrf
        @if (isset($goal_transaction))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="type">Add or Remove?</label>
            <select name="type" id="type" class="goal-form-control @error('type') border-red-500 @enderror">
                <option value="Add" {{ isset($goal_transaction) && $goal_transaction->type === 'Add' ? 'selected' : '' }}>Add</option>
                <option value="Remove" {{ isset($goal_transaction) && $goal_transaction->type === 'Remove' ? 'selected' : '' }}>Remove</option>
            </select>
            @error('type')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ $goal_transaction->amount ?? old('amount') }}" class="goal-form-control @error('amount') border-red-500 @enderror">
            @error('amount')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="goal_id" value="{{ $goal->id ?? '' }}">

        <div class="flex justify-center items-center">
            <button type="submit" class="add-custom-btn m-2">
                @isset($goal_transaction)
                    Update Transaction
                @else
                    Add Transaction
                @endisset
            </button>
            <a href="{{ isset($goal) ? route('goals.show', $goal->id) : route('goals.index') }}" class="cancel-custom-btn">Cancel</a>
        </div>
    </form>

    @isset($goal_transaction)
        <form action="{{ route('goal_transactions.destroy', $goal_transaction->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-custom-btn">Delete</button>
        </form>
    @endisset
</div>

</x-app-layout>
