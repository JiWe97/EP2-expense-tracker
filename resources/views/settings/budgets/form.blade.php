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
      action="{{ isset($budget) ? route('budgets.update', $budget->id) : route('budgets.store') }}">
      @csrf
      @isset($budget)
        @method('PUT')
      @endisset
      <div class="mb-4">
        <label for="name">Budget Name</label>
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
          <label for="banking_record_id">Bank Account</label>
          <select name="banking_record_id" id="banking_record_id" @class(['border-red-500' => $errors->has('banking_record_id')])>
              <option value="" disabled selected>Select a bank account</option>
              @foreach($banking_records as $record)
                  <option value="{{ $record->id }}" {{ (isset($budget) && $record->id == $budget->banking_record_id) ? 'selected' : '' }}>{{ $record->bank_name }}</option>
              @endforeach
          </select>
          @error('banking_record_id')
              <p class="error">{{ $message }}</p>
          @enderror
      </div>

      <div class="mb-4">
          <label for="completely">Mail if completely spent?</label>
          <input type="hidden" name="completely" value="0"> <!-- Add this line -->
          <input type="checkbox" name="completely" id="completely" value="1" @class(['border-red-500' => $errors->has('completely')]) {{ isset($budget) && $budget->mail_when_completely_spent ? 'checked' : '' }}>
      </div>
      <div class="mb-4">
          <label for="partially">Mail if 80% spent?</label>
          <input type="hidden" name="partially" value="0"> <!-- Add this line -->
          <input type="checkbox" name="partially" id="partially" value="1" @class(['border-red-500' => $errors->has('partially')]) {{ isset($budget) && $budget->mail_when_partially_spent ? 'checked' : '' }}>
      </div>


      <div class="mb-4">
            <label>Categories</label><br>
            <div style="display: flex; flex-wrap: wrap;">
                @foreach($categories as $category)
                    <label for="category_{{ $category->id }}" style="margin-right: 10px;">
                        <input type="checkbox" name="category_id[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ (isset($budget) && $budget->categories->contains($category->id)) ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('category_id')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

      <div class="flex items-center gap-2">
          <button type="submit" class="btn">
              @isset($budget)
                  Update Budget
              @else
                  Add Budget
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
