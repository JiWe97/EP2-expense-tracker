@extends('layouts.custom')

@section('title', $custom_category->displayname)

@section('content')
<div class="mb-4">
      <a href="{{ route('custom_categories.index') }}" class="link">Back</a>
</div>

<div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $custom_category->color }}">
    <i class="{{ $custom_category->icon }}" style="color: #fff;"></i>
    {{-- <i class="{{ $category->icon }}" style="color: #000;"></i> --}}
</div>
<span class="text-sm font-medium">{{ $custom_category->displayname }}</span>

<p class="mb-4">
    @if($custom_category->show)
        <span class="font-medium text-green-500"><i class="fa fa-eye"></i></span>
    @else
        <span class="font-medium text-red-500"><i class="fa fa-eye-slash"></i></span>
    @endif
</p>

<div class="flex gap-2">
    <a href="{{ route('custom_categories.edit', ['custom_category' => $custom_category->id]) }}" class="btn">Edit</a>

   {{--  <form action="{{ route('custom_categories.toggle-show', ['custom_category' => $custom_category->id])}}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn">{{ $custom_category->show ? 'Hide' : 'show' }}</button>
    </form> --}}

    <form action="{{ route('custom_categories.destroy', ['custom_category' => $custom_category->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn">Delete</button>
    </form>
</div>
@endsection