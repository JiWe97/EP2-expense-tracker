
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>


    @include('layouts.styles')



    <nav class="mb-4">
        <a href="{{ route('categories.create') }}" class="category-list-add-link">Add Category</a>
    </nav>
    
    
    <div class="mb-8">
        <h2 class="category-list-header">Income Categories</h2>
        <div class="category-list-grid-container">
            @foreach($incomeCategories as $category)
                @include('components.category-item', ['category' => $category])
            @endforeach
        </div>
    </div>
    
    <div class="mb-8">
        <h2 class="category-list-header">Expense Categories</h2>
        <div class="category-list-grid-container">
            @foreach($expenseCategories as $category)
                @include('components.category-item', ['category' => $category])
            @endforeach
        </div>
    </div>


</x-app-layout>
