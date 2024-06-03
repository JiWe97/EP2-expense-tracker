@extends('layouts.app')

@section('title', 'The list of categories')

@section('content')
    <nav class="mb-4">
        <a href="{{ route('categories.create') }}" class="link">Add Category</a>
    </nav>
    <div class="flex flex-wrap -m-2">
        @foreach($categories as $index => $category)
            <div class="p-2 w-1/2">
                <ul class="list-none p-0">
                    <li class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $category->show? $category->color : 'transparent' }}">
                            <i class="{{ $category->icon }}" style="color: {{ $category->show? '#ffffff' : '#d3d3d3' }}"></i>
                        </div>
                        <a href="{{ route('categories.show', ['category' => $category->name]) }}" class="text-sm font-medium {{ $category->show? '' : 'text-gray-400' }}">
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
@endsection
