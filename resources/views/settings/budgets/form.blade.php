@extends('layouts.custom')

@section('title', isset($budget) ? 'Edit budget' : 'Add budget')

@section('styles')
  <style>
    .error {
      color: red;
      font-size: 0.8rem;
    }
  </style>
@endsection

@section('content')
    <div class="mb-4">
        <a href="{{ route('budgets.index') }}" class="link">Back</a>
    </div>
  <form method="POST"
    action="{{ isset($budget) ? route('budgets.update', ['budget' => $budget->id, 'category' => $category->id]) : route('budgets.store') }}">
    @csrf
    @isset($budget)
      @method('PUT')
    @endisset
    <div class="mb-4">
      <label for="name">budget name</label>
      <input text="text" name="name" id="name" @class(['border-red-500' => $errors->has('name')]) value="{{ $budget->name ?? old('name') }}" />
      @error('name')
        <p class="error">{{ $message }}</p>
      @enderror
    </div> 

    <div class="mb-4">
        <label for="amount">Amount</label>
        <input type="amount" name="amount" id="amount" @class(['border-red-500' => $errors->has('amount')]) value="{{ $budget->amount?? old('amount') }}">
        @error('amount')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <input type="hidden" name="banking_record_id" id="banking_record_id" value="1">


   {{-- <div class="mb-4">
    <label for="completely">Mail if completely spent?</label>
    <input type="checkbox" name="completely" id="completely" @class(['border-red-500' => $errors->has('completely')]) {{ $budget->mail_when_completely_spent? 'checked' : '' }}>
    </div>
    <div class="mb-4">
        <label for="partially">Mail if 80% spent?</label>
        <input type="checkbox" name="partially" id="partially" @class(['border-red-500' => $errors->has('partially')]) {{ $budget->mail_when_partially_spent? 'checked' : '' }}>
    </div> --}}

   {{--  <div class="mb-4">
        <label for="category">category</label>
        <select name="category" id="category" @class(['border-red-500' => $errors->has('category')]):
            @error('category')
                <option value="" disabled selected>Select a category</option>
            @enderror
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category')
            <p class="error">{{ $message }}</p>
        @enderror
    </div> --}}

    <div class="flex items-center gap-2">
      <button type="submit" class="btn">
        @isset($budget)
          Update budget
        @else
          Add budget
        @endisset
      </button>
      <a href="{{ route('budgets.index') }}" class="link">Cancel</a>
    </div>
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