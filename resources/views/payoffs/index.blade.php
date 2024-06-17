@extends('layouts.custom')

@section('title', 'The list of payoffs')

@section('content')
    <div class="mb-4">
        <a href="{{ route('payoffs.create') }}" class="link">Add Payoff</a>
    </div>
    
    @if ($payoffs->isEmpty())
        <div class="flex justify-center items-center">
            <p class="font-bold">No Payoffs</p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach ($payoffs as $payoff)
                <div class="bg-white border border-gray-300 shadow-md p-4 rounded-lg w-full flex items-center">
                    <div class="flex-1">
                        <a href="{{ route('payoffs.show', ['payoff' => $payoff->id]) }}" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                            {{ $payoff->name }}
                        </a>
                        <p class="text-sm text-gray-500">Total: € {{ number_format($payoff->total, 2) }}</p>
                        <p class="text-sm text-gray-500">Balance: € {{ number_format($payoff->balance, 2) }}</p>
                    </div>
                    <div class="w-16 h-16 relative">
                        @php
                            $progress = $payoff->total > 0 ? ($payoff->balance / $payoff->total) * 100 : 0;
                        @endphp
                        <svg class="w-full h-full transform rotate-90">
                            <circle class="text-gray-300" stroke-width="4" stroke="currentColor" fill="transparent" r="28" cx="32" cy="32" />
                            <circle class="text-blue-500" stroke-width="4" stroke-dasharray="176" stroke-dashoffset="{{ 176 - (176 * $progress) / 100 }}" stroke="currentColor" fill="transparent" r="28" cx="32" cy="32" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-semibold text-gray-700">{{ round($progress) }}%</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
