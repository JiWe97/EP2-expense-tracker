@extends('layouts.custom')

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
                    <!-- Check if a custom category exists for this category and has a display name -->
                    @if($category->customCategory && $category->customCategory->displayname)
                        <a href="{{ route('categories.show', ['category' => $category->customCategory->displayname]) }}" class="text-sm font-medium {{ $category->show? '' : 'text-gray-400' }}">
                            <span>{{ $category->customCategory->displayname }}</span>
                        </a>
                    @else
                        <a href="{{ route('categories.show', ['category' => $category->name]) }}" class="text-sm font-medium {{ $category->show? '' : 'text-gray-400' }}">
                            <span>{{ $category->name }}</span>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    @endforeach
</div>

    <hr>


    <form method="POST" action="{{ isset($custom_category) ? route('custom_categories.update', ['custom_category' => $custom_category->id]) : route('custom_categories.store') }}">
    @csrf
    <div class="container">
        <h1>All Categories</h1>
        {{-- display logged in user id on screen--}}
        <p>User ID: {{ Auth::user()->id }}</p>


        <!-- Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Display Name</th>
                    <th>Custom Category ID</th>
                    <th>Custom Category Category ID</th>
                    <th>Action</th> <!-- Add Action column for the submit button -->
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @php $customCategory = $custom_categories->firstWhere('category_id', $category->id); @endphp
                            <input type="text" class="form-control" 
                                name="custom_category[{{ $customCategory ? $customCategory->id : 'new_' . $loop->index }}][displayname]"
                                value="{{ $customCategory ? $customCategory->displayname : '' }}"
                                placeholder="Enter Display Name">
                            <input type="hidden" name="custom_category[{{ $customCategory ? $customCategory->id : 'new_' . $loop->index }}][category_id]" value="{{ $category->id }}">
                            <input type="hidden" name="custom_category[{{ $customCategory ? $customCategory->user_id : 'new_' . $loop->index }}][user_id]" value="{{ Auth::user()->id }}">
                        </td>
                        <td>{{ $customCategory ? $customCategory->id : '' }}</td>
                        <td>{{ $customCategory ? $customCategory->category_id : $category->id }}</td>
                        <td>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td> <!-- Add a submit button in the Action column -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection