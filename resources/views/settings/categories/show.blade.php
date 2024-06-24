<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="back-link">Back</a>
    </div>

    <div class="category-header mb-4">
        <div class="category-icon" style="background-color: {{ $category->color }}">
            <i class="{{ $category->icon }}" style="color: #fff;"></i>
        </div>
        <div class="category-info m-2">
            <span class="category-name">{{ $category->name }}</span>
            <span class="income-expense-tag {{ $category->is_income ? 'income-tag' : 'expense-tag' }}">
                {{ $category->is_income ? 'Income' : 'Expense' }}
            </span>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="edit-custom-btn">Edit</a>

        <form action="{{ route('categories.toggle-show', ['category' => $category->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="toggle-visibility-btn hide-custom-btn">
                @if ($category->show)
                    <i class="fa fa-eye"></i> Visible
                @else
                    <i class="fa fa-eye-slash"></i> Hidden
                @endif
            </button>
        </form>
    </div>

    <div class="delete-form delete-custom-btn">
        @livewire('deletecategory', ['category' => $category])
    </div>
</x-app-layout>
