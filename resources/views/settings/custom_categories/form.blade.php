@extends('layouts.custom')

@section('title', isset($custom_category) ? 'Edit' : 'Add')

@section('styles')
  <style>
    .error {
      color: red;
      font-size: 0.8rem;
    }
  </style>
@endsection

@section('content')
  <form method="POST"
    action="{{ isset($custom_category) ? route('custom_categories.update', ['custom_category' => $custom_category->id]) : route('custom_.store') }}">
    @csrf
    @isset($custom_category)
      @method('PUT')
    @endisset
    <div class="mb-4">
      <label for="name">Category name</label>
      <input text="text" name="name" id="name" @class(['border-red-500' => $errors->has('name')]) value="{{ $custom_category->displayname ?? old('displayname') }}" />
      @error('name')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
        <label for="color">Color</label>
        <input type="color" name="color" id="color" @class(['border-red-500' => $errors->has('color')]) value="{{ $custom_category->color?? old('color') }}">
        @error('color')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

   <div class="mb-4">
    <label for="icon">Icon</label>
    <select name="icon" id="icon" @class(['border-red-500' => $errors->has('icon')]):
        @error('icon')
            <option value="" disabled selected>Select an Icon</option>
        @enderror
        <option value="fas fa-paint-brush">Paint Brush</option>
        <option value="fas fa-car">Car</option>
        <option value="fas fa-users">Users</option>
        <option value="fas fa-utensils">Utensils</option>
        <option value="fas fa-gift">Gift</option>
        <option value="fas fa-shopping-basket">Shopping Basket</option>
        <option value="fas fa-heartbeat">Heartbeat</option>
        <option value="fas fa-book">Book</option>
        <option value="fas fa-plane">Plane</option>
        <option value="fas fa-file-invoice-dollar">File Invoice Dollar</option>
        <option value="fas fa-shopping-cart">Shopping Cart</option>
        <option value="fas fa-football-ball">Football Ball</option>
        <option value="fas fa-ellipsis-h">Ellipsis H</option>
        <option value="fas fa-paw">Paw</option>
        <option value="fas fa-home">Home</option>
        <option value="fas fa-film">Film</option>
        <option value="fas fa-bus">Bus</option>
        <option value="fas fa-shield-alt">Shield Alt</option>
        <option value="fas fa-briefcase">Briefcase</option>
    </select>
    @error('icon')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

    <div class="flex items-center gap-2">
      <button type="submit" class="btn">
        @isset($custom_category)
          Update custom_category
        @else
          Add custom_category
        @endisset
      </button>
      <a href="{{ route('custom_categories.index') }}" class="link">Cancel</a>
    </div>
  </form>
@endsection