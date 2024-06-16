@extends('layouts.custom')

@push('styles')
    @include('layouts.styles')
@endpush

@section('content')
<div class="container mx-auto py-8">
    <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="text-gray-600 hover:text-gray-900 mb-5 inline-block">Back</a>
    <h1 class="text-3xl font-bold mb-8">History for {{ $budget->name }}</h1>

    <form method="GET" action="{{ route('budgets.history', ['budgetId' => $budget->id]) }}" class="mb-8 bg-gray-100 p-4 rounded-lg shadow-sm text-sm">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="year" class="block text-xs font-medium text-gray-600">Year</label>
                <input type="number" name="year" id="year" value="{{ request('year') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-xs">
            </div>
            <div>
                <label for="month" class="block text-xs font-medium text-gray-600">Month</label>
                <input type="number" name="month" id="month" value="{{ request('month') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-xs">
            </div>
            <div>
                <label for="sort_spent" class="block text-xs font-medium text-gray-600">Sort by Amount Spent</label>
                <select name="sort_spent" id="sort_spent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-xs">
                    <option value="">None</option>
                    <option value="highest" {{ request('sort_spent') == 'highest' ? 'selected' : '' }}>Highest</option>
                    <option value="lowest" {{ request('sort_spent') == 'lowest' ? 'selected' : '' }}>Lowest</option>
                </select>
            </div>
            <div>
                <label for="sort_remaining" class="block text-xs font-medium text-gray-600">Sort by Amount Remaining</label>
                <select name="sort_remaining" id="sort_remaining" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-xs">
                    <option value="">None</option>
                    <option value="highest" {{ request('sort_remaining') == 'highest' ? 'selected' : '' }}>Highest</option>
                    <option value="lowest" {{ request('sort_remaining') == 'lowest' ? 'selected' : '' }}>Lowest</option>
                </select>
            </div>
        </div>
        <div class="mt-2 text-right">
            <button type="submit" class="bg-gray-800 text-white py-1 px-3 rounded-md shadow hover:bg-gray-700 text-xs">Apply Filters</button>
        </div>
    </form>

    @if ($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border-b border-gray-300 px-4 py-2 text-left text-sm">Year</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-left text-sm">Month</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-left text-sm">Total Amount Spent</th>
                        <th class="border-b border-gray-300 px-4 py-2 text-left text-sm">Remaining Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $history)
                        <tr class="hover:bg-gray-100">
                            <td class="border-b border-gray-300 px-4 py-2 text-sm">{{ $history->year }}</td>
                            <td class="border-b border-gray-300 px-4 py-2 text-sm">{{ $history->month_name }}</td>
                            <td class="border-b border-gray-300 px-4 py-2 text-sm">€ {{ $history->total_amount }}</td>
                            <td class="border-b border-gray-300 px-4 py-2 text-sm">€ {{ $history->remaining_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-700">There is no history for this budget. Come back next month!</p>
    @endif
</div>
@endsection
