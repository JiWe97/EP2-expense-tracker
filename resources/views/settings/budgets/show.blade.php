@extends('layouts.custom')

@section('title', $budget->name)

@section('content')

<div class="mb-4">
    <a href="{{ route('budgets.index') }}" class="link">Back</a>
</div>

<div class="mb-4 flex gap-2 items-center">
    <p class="font-bold">€ {{ $budget->amount }}</p>
    @foreach($budget->categories as $category)
        <div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $category->color }}">
            <i class="{{ $category->icon }}" style="color: #fff;"></i>
        </div>
    @endforeach
</div>

<div class="mb-4">
    @if ($budget->mail_when_completely_spent)
        <p>You will receive an email when your budget is completely spent.</p>
    @endif
    @if ($budget->mail_when_partially_spent)
        <p>You will receive an email when your budget is 80% spent</p>
    @endif
</div>

<div class="mb-4">
    @livewire('progressbar', ['budget' => $budget, 'budgetId' => $budget->id, 'transactions' => \App\Models\Transaction::whereIn('category_id', $budget->categories->pluck('id'))->get()])
</div>

@endsection
