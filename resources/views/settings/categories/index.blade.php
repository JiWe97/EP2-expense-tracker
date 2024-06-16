@extends('layouts.custom')

@section('title', 'The List of Categories')

@push('styles')
    @include('layouts.styles')
@endpush

@section('content')
    <nav class="mb-4">
        <a href="{{ route('categories.create') }}" class="link">Add Category</a>
    </nav>
    
    <div class="mb-8">
        <h2 class="header">Income Categories</h2>
        <div class="grid-container">
            @foreach($incomeCategories as $category)
                @include('components.category-item', ['category' => $category])
            @endforeach
        </div>
    </div>
    
    <div class="mb-8">
        <h2 class="header">Expense Categories</h2>
        <div class="grid-container">
            @foreach($expenseCategories as $category)
                @include('components.category-item', ['category' => $category])
            @endforeach
        </div>
    </div>
@endsection
