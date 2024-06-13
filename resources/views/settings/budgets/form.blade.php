@extends('layouts.custom')

@section('title', isset($budget) ? 'Edit budget' : 'Add budget')

@section('styles')
    <style>
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"],
        .form-container select {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-container input[type="checkbox"] {
            margin-right: 8px;
            vertical-align: middle; /* Aligns the checkbox vertically */
        }

        .form-container .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center; /* Aligns the items vertically */
            gap: 10px;
        }

        .form-container .checkbox-group label {
            display: flex;
            align-items: center; /* Aligns checkbox with label text */
            font-weight: normal;
            font-size: 14px;
        }

        .form-container .checkbox-group label input[type="checkbox"] {
            margin-right: 6px;
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .form-container .checkbox-group label input[type="checkbox"]:checked {
            background-color: #333;
            border-color: #333;
        }

        .form-container .checkbox-group label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .form-container .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container .btn:hover {
            background-color: #555;
        }

        .form-container .link {
            color: #333;
            text-decoration: underline;
        }

        .form-container .link:hover {
            color: #555;
        }

        .form-container .error {
            color: red;
            font-size: 0.9rem;
        }

        .form-container .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="mb-4">
        <a href="{{ route('budgets.index') }}" class="link">Back</a>
    </div>
    <div class="form-container">
        <form method="POST" action="{{ isset($budget) ? route('budgets.update', $budget->id) : route('budgets.store') }}">
            @csrf
            @isset($budget)
                @method('PUT')
            @endisset
            <div class="mb-4">
                <label for="name">Budget Name</label>
                <input type="text" name="name" id="name" @class(['border-red-500' => $errors->has('name')]) value="{{ $budget->name ?? old('name') }}" />
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" @class(['border-red-500' => $errors->has('amount')]) value="{{ $budget->amount ?? old('amount') }}">
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
                <input type="hidden" name="completely" value="0">
                <input type="checkbox" name="completely" id="completely" value="1" @class(['border-red-500' => $errors->has('completely')]) {{ isset($budget) && $budget->mail_when_completely_spent ? 'checked' : '' }}>
            </div>

            <div class="mb-4">
                <label for="partially">Mail if 80% spent?</label>
                <input type="hidden" name="partially" value="0">
                <input type="checkbox" name="partially" id="partially" value="1" @class(['border-red-500' => $errors->has('partially')]) {{ isset($budget) && $budget->mail_when_partially_spent ? 'checked' : '' }}>
            </div>

            <div class="mb-4">
                <label>Categories</label><br>
                <div class="checkbox-group">
                    @foreach($categories as $category)
                        <label for="category_{{ $category->id }}">
                            <input type="checkbox" name="category_id[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ (isset($budget) && $budget->categories->contains($category->id)) ? 'checked' : '' }}>
                            <span>{{ $category->name }}</span>
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
                <div class="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
@endsection
