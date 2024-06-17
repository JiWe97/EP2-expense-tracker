@extends('layouts.custom')

@section('title', isset($payoff) ? 'Edit Payoff' : 'Create Payoff')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-group button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    .form-group button:hover {
        background-color: #0056b3;
    }
</style>
@endsection

@section('content')
<div class="container form-container">
    <h1>{{ isset($payoff) ? 'Edit Payoff' : 'Create Payoff' }}</h1>
    <form method="POST" action="{{ isset($payoff) ? route('payoffs.update', $payoff) : route('payoffs.store') }}">
        @csrf
        @if(isset($payoff))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $payoff->name ?? '') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" id="total" name="total" value="{{ old('total', $payoff->total ?? '') }}" required>
            @error('total')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" id="balance" name="balance" value="{{ old('balance', $payoff->balance ?? '') }}" required>
            @error('balance')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit">{{ isset($payoff) ? 'Update Payoff' : 'Create Payoff' }}</button>
        </div>
    </form>
</div>
@endsection
