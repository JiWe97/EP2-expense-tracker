@extends('layouts.app')

@section('title', 'The list of budgets')

@section('content')
    <nav class="mb-4">
        <a href="{{ route('budgets.create') }}" class="link">Add Budget</a>
    </nav>
    {{-- 'No budget' when there aren't any budgets --}}
    @if(count($budgets) == 0)
        <div class="flex justify-center items-center">
            <p class="font-bold">No Budgets</p>
        </div>
    @endif
    <div class="flex flex-wrap -m-2">
        @foreach($budgets as $budget)
            <div class="p-2 w-1/2">
                <ul class="list-none p-0">
                    <li class="flex items-center space-x-2">
                        {{ $budget->name }} - {{ $budget->amount }}
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
      <x-progress-bar></x-progress-bar>
@endsection
