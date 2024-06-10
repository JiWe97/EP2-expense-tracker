@extends('layouts.custom')

@section('content')
<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="link">Back</a>
</div>

<div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $category->color }}">
    <i class="{{ $category->icon }}" style="color: #fff;"></i>
</div>

{{-- Display custom category name if exists, else display regular category name --}}
@if(isset($custom_category) && $custom_category->category_id == $category->id)
    <span class="text-sm font-medium">{{ $custom_category->displayname }}</span>
@else
    <span class="text-sm font-medium">{{ $category->name }}</span>
@endif

<p class="mb-4">
    @if($category->show)
        <span class="font-medium text-green-500"><i class="fa fa-eye"></i></span>
    @else
        <span class="font-medium text-red-500"><i class="fa fa-eye-slash"></i></span>
    @endif
</p>

<div class="mb-4">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
</div>

<div class="flex gap-2">
    <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn">Edit</a>

    <form action="{{ route('categories.toggle-show', ['category' => $category->id])}}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn">{{ $category->show ? 'Hide' : 'Show' }}</button>
    </form>

    @if(isset($custom_category) && $custom_category->category_id == $category->id)
        <form action="{{ route('categories.destroy', ['category' => $custom_category->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Reset to default values</button>
        </form>
    @endif
</div>
@endsection
