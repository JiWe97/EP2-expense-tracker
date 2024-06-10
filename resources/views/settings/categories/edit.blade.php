@extends('layouts.custom')

@section('content')
{{-- @include('settings.categories.form') --}}

<form method="POST" action="{{ route('categories.save', ['category' => $category->id]) }}">
    @csrf
    <p>CC_id: {{ $custom_category->category_id ?? 'None' }} en C_id: {{ $category->id }}</p>
    <div class="mb-4">
        <label for="displayname">Name</label>
        <input type="text" name="displayname" id="displayname" @class(['border-red-500' => $errors->has('displayname')]) value="{{ $custom_category->displayname ?? old('displayname') }}" />
        @error('displayname')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="color">Color</label>
        <input type="color" name="color" id="color" @class(['border-red-500' => $errors->has('color')]) value="{{ $custom_category->color ?? old('color') }}">
        @error('color')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="icon">Icon</label>
        <select name="icon" id="icon" @class(['border-red-500' => $errors->has('icon')])>
            <option value="" disabled {{ !$custom_category->icon && !old('icon') ? 'selected' : '' }}>Select an Icon</option>
            <option value="fas fa-paint-brush" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-paint-brush' ? 'selected' : '' }}>Paint Brush</option>
            <option value="fas fa-car" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-car' ? 'selected' : '' }}>Car</option>
            <option value="fas fa-users" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-users' ? 'selected' : '' }}>Users</option>
            <option value="fas fa-utensils" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-utensils' ? 'selected' : '' }}>Utensils</option>
            <option value="fas fa-gift" {{ (old('icon') ?? $custom_category->icon) == 'category' ? 'selected' : '' }}>Gift</option>
            <option value="fas fa-shopping-basket" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-shopping-basket' ? 'selected' : '' }}>Shopping Basket</option>
            <option value="fas fa-heartbeat" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-heartbeat' ? 'selected' : '' }}>Heartbeat</option>
            <option value="fas fa-book" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-book' ? 'selected' : '' }}>Book</option>
            <option value="fas fa-plane" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-plane' ? 'selected' : '' }}>Plane</option>
            <option value="fas fa-file-invoice-dollar" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-file-invoice-dollar' ? 'selected' : '' }}>File Invoice Dollar</option>
            <option value="fas fa-shopping-cart" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-shopping-cart' ? 'selected' : '' }}>Shopping Cart</option>
            <option value="fas fa-football-ball" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-football-ball' ? 'selected' : '' }}>Football Ball</option>
            <option value="fas fa-ellipsis-h" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-ellipsis-h' ? 'selected' : '' }}>Ellipsis H</option>
            <option value="fas fa-paw" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-paw' ? 'selected' : '' }}>Paw</option>
            <option value="fas fa-home" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-home' ? 'selected' : '' }}>Home</option>
            <option value="fas fa-film" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-film' ? 'selected' : '' }}>Film</option>
            <option value="fas fa-bus" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-bus' ? 'selected' : '' }}>Bus</option>
            <option value="fas fa-fa-shield-alt" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-shield-alt' ? 'selected' : '' }}>Shield Alt</option>
            <option value="fas fa-briefcase" {{ (old('icon') ?? $custom_category->icon) == 'fas fa-briefcase' ? 'selected' : '' }}>Briefcase</option>
            
        </select>
        @error('icon')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    </div>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('categories.index') }}" class="link">Cancel</a>
</form>
@endsection