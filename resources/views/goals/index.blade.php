<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Goals') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    
    <nav class="mb-4">
        <a href="{{ route('goals.create') }}" class="add-goal-link">Add Goal</a>
    </nav>
    <div class="goal-container-wrapper">
        @if (count($goals) == 0)
            <div class="no-goals">
                <p>No goals</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($goals as $goal)
                    <div class="card bg-white shadow-md rounded-lg p-6 goal-card">
                        <a href="{{ route('goals.show', ['goal' => $goal->id]) }}" class="goal-link block">
                            <h3 class="text-lg font-semibold mb-2">{{ $goal->name }}</h3>
                            <p class="text-gray-600">€ {{ $goal->amount }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
