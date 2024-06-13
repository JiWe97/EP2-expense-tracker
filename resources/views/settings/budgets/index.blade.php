@extends('layouts.custom')

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
    <div class="flex flex-col gap-4">
    @foreach($budgets as $budget)
        <div class="bg-white border border-gray-300 shadow-md p-4 rounded-lg w-full">
            <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="text-lg font-medium text-gray-700 hover:text-gray-900">        
                <div class="flex justify-between items-center">
                    <div>
                        {{ $budget->name }}
                    </div>
                    <div class="flex items-center">
                        @foreach($budget->categories as $category)
                            <div class="w-10 h-10 rounded-full flex justify-center items-center m-1" style="background-color: {{ $category->color }};">
                                <i class="{{ $category->icon }}" style="color: #fff;"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

@endsection
