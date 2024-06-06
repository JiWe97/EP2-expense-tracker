@extends('layouts.custom')

@section('title', 'The list of custom_categories')

@section('content')
    <nav class="mb-4">
        <a href="{{ route('custom_categories.create') }}" class="link">Add custom_category</a>
    </nav>
    <div class="flex flex-wrap -m-2">
        @foreach($custom_categories as $index => $custom_category)
            <div class="p-2 w-1/2">
                <ul class="list-none p-0">
                    <li class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $custom_category->show? $custom_category->color : 'transparent' }}">
                            <i class="{{ $custom_category->icon }}" style="color: {{ $custom_category->show? '#ffffff' : '#d3d3d3' }}"></i>
                        </div>
                        <a href="{{ route('custom_categories.show', ['custom_category' => $custom_category->displayname]) }}" class="text-sm font-medium {{ $custom_category->show? '' : 'text-gray-400' }}">
                            <span>{{ $custom_category->displayname }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
   
@endsection