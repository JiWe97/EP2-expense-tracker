@extends('layouts.custom')

@section('title', 'The list of budgets')

@section('styles')
    <style>
        .budget-item {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e2e8f0;
            border-radius: 0.5rem;
            height: 1rem;
            margin-top: 0.5rem;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            background-color: #4299e1;
            height: 100%;
            border-radius: 0.5rem;
            transition: width 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-text {
            font-size: 0.8rem;
            color: #fff;
            padding: 0 5px;
            z-index: 1;
        }

        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .category-icon + .category-icon {
            margin-left: 0.2rem;
        }

        .remaining {
            font-size: 0.9rem;
            color: #888;
            text-align: right;
            margin-top: 0.5rem;
        }

        .budget-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            width: 100%;
        }

        .budget-name {
            white-space: nowrap;
            overflow: visible;
            text-overflow: ellipsis;
        }

        .category-icons-container {
            display: flex;
            overflow-x: auto;
            align-items: center;
            flex-shrink: 1;
            margin-left: 1rem;
            max-width: auto;
        }

        .category-icons {
            display: flex;
            align-items: center;
        }

        .budget-details {
            display: flex;
            flex-direction: column;
            width: 100%;
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
            <div class="budget-item">
                <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                    <div class="budget-header">
                        <div class="budget-name">
                            {{ $budget->name }}
                        </div>
                        <div class="category-icons-container">
                            <div class="category-icons">
                                @foreach ($budget->categories as $category)
                                    <div class="category-icon" style="background-color: {{ $category->color }};">
                                        <i class="{{ $category->icon }}" style="color: #fff;"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="budget-details">
                        <div class="progress-bar-container">
                            @php
                                $progress = $budget->amount > 0 ? abs($budget->balance / $budget->amount) * 100 : 0;
                                $remaining = $budget->amount - $budget->balance;
                            @endphp
                            <div class="progress-bar" style="width: {{ $progress }}%;">
                                @if ($progress > 0)
                                    <div class="progress-text">{{ number_format($progress, 2) }}%</div>
                                @endif
                            </div>
                        </div>
                        <p class="remaining">Remaining: €{{ number_format($remaining, 2) }} / €{{ number_format($budget->amount, 2) }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
