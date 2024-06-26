<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Budgets') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    <div class="budget-show-container">
        <div class="header-show">
            <a href="{{ route('budgets.index') }}" class="back-link">Back</a>
            <h1 class="text-3xl font-bold title-show">{{ $budget->name }}</h1>
            <a href="{{ route('budgets.history', ['budgetId' => $budget->id]) }}" class="budget-history-link-custom">View History</a>
        </div>

        <div class="flex items-center mb-6">
            <p class="font-bold text-xl">€ {{ $budget->amount }}</p>
            <div class="flex items-center ml-4">
                @foreach ($budget->categories as $category)
                    <div class="category-icon-show" style="background-color: {{ $category->color }}">
                        <i class="{{ $category->icon }}" style="color: #fff;"></i>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-6">
            @if ($budget->mail_when_completely_spent)
                <div class="info-message-show">
                    <i class="fa fa-envelope"></i>
                    <p>You will receive an email when your budget is completely spent.</p>
                </div>
            @endif
            @if ($budget->mail_when_partially_spent)
                <div class="info-message-show">
                    <i class="fa fa-envelope"></i>
                    <p>You will receive an email when your budget is 80% spent.</p>
                </div>
            @endif
        </div>

        <div class="mb-6">
            @livewire('progressbar', [
                'budget' => $budget,
                'budgetId' => $budget->id,
                'transactions' => \App\Models\Transaction::whereIn('category_id', $budget->categories->pluck('id'))->get()
            ])
        </div>

        <div class="actions-show mb-6">
            <a href="{{ route('budgets.edit', ['budget' => $budget->id]) }}" class="edit-custom-btn">Edit</a>
            <form method="POST" action="{{ route('budgets.destroy', ['budget' => $budget->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-custom-btn">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>
