@extends('layouts.custom')

@section('title', $category->name)

@section('content')
<div class="mb-4">
      <a href="{{ route('categories.index') }}" class="link">Back</a>
</div>

<div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $category->color }}">
    <i class="{{ $category->icon }}" style="color: #fff;"></i>
    {{-- <i class="{{ $category->icon }}" style="color: #000;"></i> --}}
</div>
<span class="text-sm font-medium">{{ $category->name }}</span>

<p class="mb-4">
    @if($category->show)
        <span class="font-medium text-green-500"><i class="fa fa-eye"></i></span>
    @else
        <span class="font-medium text-red-500"><i class="fa fa-eye-slash"></i></span>
    @endif
</p>

<div class="mb-4">
    <input type="hidden" name="user_id" value="1">
</div>

<div class="flex gap-2">
    <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn">Edit</a>

    <form action="{{ route('categories.toggle-show', ['category' => $category->id])}}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn">{{ $category->show ? 'Hide' : 'show' }}</button>
    </form>

    <form action="{{ route('categories.destroy', ['category' => $category->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn">Delete</button>
    </form>
</div>
@endsection