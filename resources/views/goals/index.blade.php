@extends('layouts.custom')

@section('title', 'The list of goals')

@section('content')
    <nav class="mb-4">
        <a href="{{ route('goals.create') }}" class="link">Add Goal</a>
    </nav>
    {{-- 'No goal' when there aren't any goals --}}
    @if(count($goals) == 0)
        <div class="flex justify-center items-center">
            <p class="font-bold">No goals</p>
        </div>
    @endif
    <div class="flex flex-col gap-2">
        @foreach($goals as $goal)
            <div class="p-2">
                <ul class="list-none p-0">
                    <li class="flex items-center space-x-2">
                        <a href="{{ route('goals.edit', ['goal' => $goal->id]) }}" class="text-sm font-medium">
                            <span>{{ $goal->name }} - € {{ $goal->amount }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
@endsection
