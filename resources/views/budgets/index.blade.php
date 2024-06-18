@extends('layouts.custom')

@section('title', 'The list of budgets')

@section('styles')
    <style>
        .budget-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e2e8f0;
            border-radius: 0.5rem;
            height: 1rem;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #4299e1;
            height: 100%;
            border-radius: 0.5rem;
            transition: width 0.3s;
        }

        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 0.5rem;
            color: #fff;
        }
    </style>
@endsection


@section('content')
    <nav class="mb-4">
        <a href="{{ route('budgets.create') }}" class="link">Add Budget</a>
    </nav>
    
    @if ($budgets->isEmpty())
        <div class="flex justify-center items-center">
            <p class="font-bold">No Budgets</p>
        </div>
    @endif
    
    <div class="flex flex-col gap-4">
        @foreach ($budgets as $budget)
            <div class="bg-white border border-gray-300 shadow-md p-4 rounded-lg w-full flex items-center justify-between">
                <div class="flex-1">
                    <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                        <div class="mb-2">
                            {{ $budget->name }}
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            @php
                                $progress = $budget->amount > 0 ? abs($budget->balance / $budget->amount) * 100 : 0;
                            @endphp
                            <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Total: € {{ number_format($budget->amount, 2) }}</p>
                        <p class="text-sm text-gray-500">Spent: € {{ number_format($budget->balance, 2) }}</p>
                        <p class="text-sm text-gray-500">Remaining: € {{ number_format($budget->amount - $budget->balance, 2) }}</p>
                    </a>
                </div>
                <div class="flex items-center ml-4">
                    @foreach ($budget->categories as $category)
                        <div class="w-10 h-10 rounded-full flex justify-center items-center m-1" style="background-color: {{ $category->color }};">
                            <i class="{{ $category->icon }}" style="color: #fff;"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
