<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loans') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    <div class="container form-container-custom">
        <h1 class="text-center">{{ isset($payoff) ? 'Edit Payoff' : 'Create Payoff' }}</h1>
        <form method="POST" action="{{ isset($payoff) ? route('payoffs.update', $payoff) : route('payoffs.store') }}">
            @csrf
            @if (isset($payoff))
                @method('PUT')
            @endif
            <div class="form-group-custom">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $payoff->name ?? '') }}" required>
                @error('name')
                    <div class="error-custom">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group-custom">
                <label for="total">Total</label>
                <input type="number" id="total" name="total" step="0.01" value="{{ old('total', $payoff->total ?? '') }}" required>
                @error('total')
                    <div class="error-custom">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group-custom">
                <label for="balance">Balance</label>
                <input type="number" id="balance" name="balance" step="0.01" value="{{ old('balance', $payoff->balance ?? '') }}" required>
                @error('balance')
                    <div class="error-custom">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group-custom">
                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
            </div>
            <div class="form-group-custom text-center">
                <button type="submit" class="btn-custom-form">{{ isset($payoff) ? 'Update Payoff' : 'Create Payoff' }}</button>
                <a href="{{ route('payoffs.index') }}" class="delete-custom-btn">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
