@extends('layouts.custom')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('styles')
  <style>
    .error {
      color: red;
      font-size: 0.8rem;
    }

    .form-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: auto;
    }

    .form-container label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
    }

    .form-container input[type="text"],
    .form-container select {
      width: calc(100% - 24px);
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .form-container .btn {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 5px;
      background-color: #4a4a4a;
      color: white;
      text-align: center;
      text-decoration: none;
      font-size: 1rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-container .btn:hover {
      background-color: #2e2e2e;
    }

    .form-container .link {
      color: #333;
      text-decoration: underline;
      cursor: pointer;
    }

    .form-container .link:hover {
      color: #555;
    }
  </style>
@endsection

@section('content')
    <div class="flex justify-center"> <!-- Center the form container -->
        <div class="form-container p-6 w-full max-w-lg"> <!-- Set max width for the form -->
            <a href="{{ route('categories.index') }}" class="link mb-4">Back</a>

            <form method="POST" action="{{ isset($category) ? route('categories.update', ['category' => $category->id]) : route('categories.store') }}">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                <div class="mb-4">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" value="{{ $category->name ?? old('name') }}" />
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="is_income" class="block text-sm font-medium text-gray-700">Income or Expense?</label>
                    <select name="is_income" id="is_income" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('is_income') border-red-500 @enderror">
                        <option value="1" {{ old('is_income', isset($category) ? $category->is_income : '') == 1 ? 'selected' : '' }}>Income</option>
                        <option value="0" {{ old('is_income', isset($category) ? $category->is_income : '') == 0 ? 'selected' : '' }}>Expense</option>
                    </select>
                    @error('is_income')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    @livewire('colorpicker', ['initialColor' => $category->color ?? old('color')])
                    @error('color')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    @livewire('iconchooser', ['initialIcon' => $category->icon ?? old('icon')])
                    @error('icon')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <div class="flex items-center gap-4">
                    <button type="submit" class="btn">
                        @isset($category)
                            Update Category
                        @else
                            Add Category
                        @endisset
                    </button>
                    <a href="{{ route('categories.index') }}" class="link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
