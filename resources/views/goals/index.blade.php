@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

@section('title', 'The list of goals')

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
    
        <nav class="mb-4">
            <a href="{{ route('goals.create') }}" class="add-goal-link">Add Goal</a>
        </nav>
<div class="goal-container-wrapper">
        @if (count($goals) == 0)
            <div class="no-goals">
                <p>No goals</p>
            </div>
        @endif

        <div class="goal-container">
            @foreach ($goals as $goal)
                <div class="goal-header">
                    <a href="{{ route('goals.show', ['goal' => $goal->id]) }}" class="goal-link">
                        <span class="goal-title">{{ $goal->name }}</span>
                    </a>
                    <span class="goal-amount">€ {{ $goal->amount }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
