@extends('layouts.custom')

@section('title', isset($category)? 'Edit Custom Category' : 'Add Custom Category')

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
    action="{{ isset($category)? route('categories.update', ['category' => $category->id]) : route('custom_categories.store') }}">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif
    <div class="mb-4">
      <label for="displayname">Display Name</label>
      <input type="text" name="displayname" id="displayname" @class(['border-red-500' => $errors->has('displayname')]) value="{{ $custom_category->displayname?? old('displayname') }}" />
      @error('displayname')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
        <label for="color">Color</label>
        <input type="color" name="color" id="color" @class(['border-red-500' => $errors->has('color')]) value="{{ $category->color?? old('color') }}">
        @error('color')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
      <input type="hidden" name="user_id" value="1">
    </div>

    <div class="mb-4">
        <label for="icon">Icon</label>
        <select name="icon" id="icon" @class(['border-red-500' => $errors->has('icon')]):
            @error('icon')
                <option value="" disabled selected>Select an Icon</option>
            @enderror
            <option value="{{ $custom_category->icon?? old('icon') }}" selected>{{ $custom_category->icon?? old('icon') }}</option>
            <option value="fas fa-paint-brush">Paint Brush</option>
            <option value="fas fa-car">Car</option>
            <option value="fas fa-users">Users</option>
            <option value="fas fa-utensils">Utensils</option>
            <option value="category">Gift</option>
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
        @isset($category)
          Update Custom Category
        @else
          Add Custom Category
        @endisset
      </button>
      <a href="{{ route('categories.index') }}" class="link">Cancel</a>
    </div>
    {{-- errormessage --}}
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif 
  </form>
@endsection
