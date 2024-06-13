@extends('layouts.custom')

@section('title', 'The List of Categories')

@section('styles')
    <style>
        .category-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .category-item:hover {
            background-color: #f5f5f5;
            transform: scale(1.02);
        }

        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 12px;
        }

        .category-link {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            text-decoration: none;
        }

        .category-link.inactive {
            color: #d3d3d3;
        }

        .category-link.inactive:hover {
            color: #a1a1a1;
        }

        .header {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
    </style>
@endsection

@section('content')
    <nav class="mb-4">
        <a href="{{ route('categories.create') }}" class="link">Add Category</a>
    </nav>
    
    <div class="mb-8">
        <h2 class="header">Income Categories</h2>
        <div class="grid-container">
            @foreach($incomeCategories as $category)
                <div class="category-item">
                    <div class="category-icon" style="background-color: {{ $category->show ? $category->color : 'transparent' }}">
                        <i class="{{ $category->icon }}" style="color: {{ $category->show ? '#ffffff' : '#d3d3d3' }}"></i>
                    </div>
                    <a href="{{ route('categories.show', ['category' => $category->id]) }}" class="category-link {{ $category->show ? '' : 'inactive' }}">
                        {{ $category->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="mb-8">
        <h2 class="header">Expense Categories</h2>
        <div class="grid-container">
            @foreach($expenseCategories as $category)
                <div class="category-item">
                    <div class="category-icon" style="background-color: {{ $category->show ? $category->color : 'transparent' }}">
                        <i class="{{ $category->icon }}" style="color: {{ $category->show ? '#ffffff' : '#d3d3d3' }}"></i>
                    </div>
                    <a href="{{ route('categories.show', ['category' => $category->id]) }}" class="category-link {{ $category->show ? '' : 'inactive' }}">
                        {{ $category->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
