@extends('layouts.custom')

@section('title', isset($goal) ? 'Edit Goal' : 'Add Goal')

@section('styles')
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .form-group .error {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-cancel {
            background-color: #6c757d;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        .flex {
            display: flex;
            gap: 1rem;
        }
        .justify-center {
            justify-content: center;
        }
        .items-center {
            align-items: center;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
    </style>
@endsection

@section('content')
<div class="form-container">
    <h1 class="text-center">{{ isset($goal) ? 'Edit Goal' : 'Add Goal' }}</h1>
    <form method="POST" action="{{ isset($goal) ? route('goals.update', $goal->id) : route('goals.store') }}">
        @csrf
        @if (isset($goal))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Goal Name</label>
            <input type="text" name="name" id="name" value="{{ $goal->name ?? old('name') }}" class="form-control @error('name') border-red-500 @enderror">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ $goal->amount ?? old('amount') }}" class="form-control @error('amount') border-red-500 @enderror">
            @error('amount')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') border-red-500 @enderror">{{ $goal->description ?? old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" value="{{ isset($goal) ? $goal->deadline->format('Y-m-d') : old('deadline') }}" class="form-control @error('deadline') border-red-500 @enderror">
            @error('deadline')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
        </div>

        <div class="flex justify-center items-center">
            <button type="submit" class="btn btn-primary">
                @isset($goal)
                    Update Goal
                @else
                    Add Goal
                @endisset
            </button>
            <a href="{{ route('goals.index') }}" class="btn btn-cancel ml-2">Cancel</a>
        </div>
    </form>

    @isset($goal)
        <form action="{{ route('goals.destroy', ['goal' => $goal->id]) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @endisset
</div>
@endsection
