@extends('layouts.custom')

@section('styles')
    <style>
        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 12px;
        }

        .btn-custom {
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #4a4a4a;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #2e2e2e;
        }

        .link-custom {
            color: #333;
            text-decoration: underline;
            cursor: pointer;
        }

        .link-custom:hover {
            color: #555;
        }

        .status-icon {
            font-size: 1.5rem;
        }

        .category-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .category-name {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .income-expense-tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .income-tag {
            background-color: #e0f7fa;
            color: #00796b;
        }

        .expense-tag {
            background-color: #ffebee;
            color: #c62828;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .delete-form {
            margin-top: 10px;
        }
    </style>
@endsection

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

    <form action="{{ route('categories.toggle-show', ['category' => $category->id])}}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn-custom">{{ $category->show ? 'Hide' : 'Show' }}</button>
    </form>
</div>

<div class="delete-form">
    <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-custom">Delete</button>
    </form>
</div>
@endsection
