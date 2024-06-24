<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Goals') }}
        </h2>
    </x-slot>

    @include('layouts.styles')
    @section('title', isset($goal) ? 'Edit Goal' : 'Add Goal')

<div class="goal-form-container">
    <h1 class="text-center">{{ isset($goal) ? 'Edit Goal' : 'Add Goal' }}</h1>
    <form method="POST" action="{{ isset($goal) ? route('goals.update', $goal->id) : route('goals.store') }}">
        @csrf
        @if (isset($goal))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Goal Name</label>
            <input type="text" name="name" id="name" value="{{ $goal->name ?? old('name') }}" class="goal-form-control @error('name') border-red-500 @enderror">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ $goal->amount ?? old('amount') }}" class="goal-form-control @error('amount') border-red-500 @enderror">
            @error('amount')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="goal-form-control @error('description') border-red-500 @enderror">{{ $goal->description ?? old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" value="{{ isset($goal) ? $goal->deadline->format('Y-m-d') : old('deadline') }}" class="goal-form-control @error('deadline') border-red-500 @enderror">
            @error('deadline')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
        </div>

        <div class="flex justify-center items-center m-2">
            <button type="submit" class="add-goal-link m-2">
                @isset($goal)
                    Update Goal
                @else
                    Add Goal
                @endisset
            </button>
            <a href="{{ route('goals.index') }}" class="cancel-custom-btn">Cancel</a>
        </div>
    </form>

    @isset($goal)
        <form action="{{ route('goals.destroy', ['goal' => $goal->id]) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-custom-btn">Delete</button>
        </form>
    @endisset
</div>

</x-app-layout>