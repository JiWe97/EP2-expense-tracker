@extends('layouts.custom')

@section('styles')
    @include('layouts.styles')
@endsection

@section('title', 'The list of payoffs')

@section('content')
    <div>
        <div class="mb-4">
            <a href="{{ route('payoffs.create') }}" class="add-payoff-link-custom">Add Payoff</a>
        </div>

        @if ($payoffs->isEmpty())
            <div class="flex justify-center items-center">
                <p class="font-bold">No Payoffs</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach ($payoffs as $payoff)
                    <a href="{{ route('payoffs.show', ['payoff' => $payoff->id]) }}" class="bg-white border border-gray-300 shadow-md p-6 rounded-lg hover:shadow-lg transition-shadow duration-300">
                        <div class="goal-header">
                            <h2 class="text-lg font-medium text-gray-700 hover:text-gray-900">{{ $payoff->name }}</h2>
                        </div>
                        <div class="goal-amount">
                            <p class="text-sm text-gray-500">Total: € {{ number_format($payoff->total, 2) }}</p>
                            <p class="text-sm text-gray-500">Balance: € {{ number_format($payoff->balance, 2) }}</p>
                        </div>
                        <div class="w-24 h-24 relative mx-auto mt-4">
                            @php
                                $progress = $payoff->total > 0 ? ($payoff->balance / $payoff->total) * 100 : 0;
                            @endphp
                            <svg class="w-full h-full transform -rotate-90">
                                <circle class="text-gray-300" stroke-width="4" stroke="currentColor" fill="transparent" r="36" cx="48" cy="48" />
                                <circle class="text-sage-green" stroke-width="4" stroke-dasharray="226" stroke-dashoffset="{{ 226 - (226 * $progress) / 100 }}" stroke="currentColor" fill="transparent" r="36" cx="48" cy="48" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-semibold text-gray-700">{{ round($progress) }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
