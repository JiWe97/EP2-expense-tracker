@extends('layouts.custom')

@section('title', 'The list of budgets')

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
    <div class="budget-container-wrapper-custom">
        <nav class="add-budget-link-custom">
            <a href="{{ route('budgets.create') }}" class="link">Add Budget</a>
        </nav>

        @if ($budgets->isEmpty())
            <div class="flex justify-center items-center">
                <p class="font-bold">No Budgets</p>
            </div>
        @endif
        
        <div class="budget-container-custom">
            @foreach ($budgets as $budget)
                <div class="budget-item-custom">
                    <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="text-lg font-medium text-gray-700 hover:text-gray-900">
                        <div class="budget-header-custom">
                            <div class="budget-name-custom">
                                {{ $budget->name }}
                            </div>
                            <div class="category-icons-container-custom">
                                <div class="category-icons-custom">
                                    @foreach ($budget->categories->take(3) as $category)
                                        <div class="category-icon-custom" style="background-color: {{ $category->color }};">
                                            <i class="{{ $category->icon }}" style="color: #fff;"></i>
                                        </div>
                                    @endforeach
                                    @if ($budget->categories->count() > 3)
                                        <div class="category-icon-custom" style="background-color: #A3BE84;">
                                            <i class="fas fa-plus" style="color: #fff;"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="budget-details-custom">
                            <div class="progress-bar-container-custom">
                                @php
                                    $progress = $budget->amount > 0 ? abs($budget->balance / $budget->amount) * 100 : 0;
                                    $remaining = $budget->amount - $budget->balance;
                                @endphp
                                <div class="progress-bar-custom" style="width: {{ $progress }}%;">
                                    @if ($progress > 0)
                                        <div class="progress-text-custom">{{ number_format($progress) }}%</div>
                                    @endif
                                </div>
                            </div>
                            <p class="remaining-custom">Remaining: €{{ number_format($remaining, 2) }} / €{{ number_format($budget->amount, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
