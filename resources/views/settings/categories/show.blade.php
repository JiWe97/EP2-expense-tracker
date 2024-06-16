@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

@section('content')
    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="link-custom">Back</a>
    </div>

    <div class="category-header mb-4">
        <div class="category-icon" style="background-color: {{ $category->color }}">
            <i class="{{ $category->icon }}" style="color: #fff;"></i>
        </div>
        <div>
            <span class="category-name">{{ $category->name }}</span>
            <div>
                <span class="income-expense-tag {{ $category->is_income ? 'income-tag' : 'expense-tag' }}">
                    {{ $category->is_income ? 'Income' : 'Expense' }}
                </span>
            </div>
        </div>
    </div>

    <div class="mb-4">
        @if($category->show)
            <span class="font-medium text-green-500 status-icon"><i class="fa fa-eye"></i> Visible</span>
        @else
            <span class="font-medium text-red-500 status-icon"><i class="fa fa-eye-slash"></i> Hidden</span>
        @endif
    </div>

    <div class="action-buttons">
        <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn-custom">Edit</a>

        <form action="{{ route('categories.toggle-show', ['category' => $category->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn-custom">{{ $category->show ? 'Hide' : 'Show' }}</button>
        </form>
    </div>

    <div class="delete-form">
        @livewire('deletecategory', ['category' => $category])
    </div>
@endsection
