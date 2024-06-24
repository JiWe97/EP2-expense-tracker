<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    @include('layouts.styles')
    @section('title', isset($category) ? 'Edit Category' : 'Add Category')

    <div class="flex justify-center"> 
        <div class="category-form-container p-6 w-full max-w-lg"> 
            <a href="{{ route('categories.index') }}" class="back-link mb-4">Back</a>

            <form method="POST" action="{{ isset($category) ? route('categories.update', ['category' => $category->id]) : route('categories.store') }}">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                <div class="mb-4">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" value="{{ $category->name ?? old('name') }}" />
                    @error('name')
                        <p class="category-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="is_income" class="block text-sm font-medium text-gray-700">Income or Expense?</label>
                    <select name="is_income" id="is_income" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('is_income') border-red-500 @enderror">
                        <option value="1" {{ old('is_income', isset($category) ? $category->is_income : '') == 1 ? 'selected' : '' }}>Income</option>
                        <option value="0" {{ old('is_income', isset($category) ? $category->is_income : '') == 0 ? 'selected' : '' }}>Expense</option>
                    </select>
                    @error('is_income')
                        <p class="category-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    @livewire('colorpicker', ['initialColor' => $category->color ?? old('color')])
                    @error('color')
                        <p class="category-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    @livewire('iconchooser', ['initialIcon' => $category->icon ?? old('icon')])
                    @error('icon')
                        <p class="category-form-error">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <div class="flex items-center gap-4">
                    <button type="submit" class="category-form-btn">
                        @isset($category)
                            Update Category
                        @else
                            Add Category
                        @endisset
                    </button>
                    <a href="{{ route('categories.index') }}" class="cancel-custom-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
