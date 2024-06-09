@extends('layouts.custom')

@section('title', isset($goal) ? 'Edit goal' : 'Add goal')

@section('styles')
    <style>
        .error {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
    <form method="POST" action="{{ isset($goal) ? route('goals.update', $goal->id) : route('goals.store') }}">
    @csrf
    @if (isset($goal))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="name">Goal Name</label>
        <input type="text" name="name" id="name" value="{{ $goal->name ?? old('name') }}">
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" value="{{ $goal->amount ?? old('amount') }}">
        @error('amount')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="{{ $goal->description ?? old('description') }}">
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="deadline">Deadline</label>
        <input type="date" name="deadline" id="deadline" value="{{ isset($goal) ? $goal->deadline->format('Y-m-d') : old('deadline') }}">
        @error('deadline')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

    <div class="flex items-center gap-2">
        <button type="submit" class="btn">
            @isset($goal)
                Update Goal
            @else
                Add Goal
            @endisset
        </button>
        <a href="{{ route('goals.index') }}" class="link">Cancel</a>
    </div>
</form>
 @isset($goal)
            <form action="{{ route('goals.destroy', ['goal' => $goal->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn">Delete</button>
            </form>
        @endisset
@endsection