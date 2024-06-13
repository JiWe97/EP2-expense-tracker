@extends('layouts.custom')

@section('content')
<div class="container">
    <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="link mb-5">Back</a>
    <h1 class="text-xl font-bold mb-5">History for {{ $budget->name }}</h1>

    <form method="GET" action="{{ route('budgets.history', ['budgetId' => $budget->id]) }}" class="mb-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <input type="number" name="year" id="year" value="{{ request('year') }}" class="mt-1 block w-full">
            </div>
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                <input type="number" name="month" id="month" value="{{ request('month') }}" class="mt-1 block w-full">
            </div>
            <div>
                <label for="sort_spent" class="block text-sm font-medium text-gray-700">Sort by Amount Spent</label>
                <select name="sort_spent" id="sort_spent" class="mt-1 block w-full">
                    <option value="">None</option>
                    <option value="highest" {{ request('sort_spent') == 'highest' ? 'selected' : '' }}>Highest</option>
                    <option value="lowest" {{ request('sort_spent') == 'lowest' ? 'selected' : '' }}>Lowest</option>
                </select>
            </div>
            <div>
                <label for="sort_remaining" class="block text-sm font-medium text-gray-700">Sort by Amount Remaining</label>
                <select name="sort_remaining" id="sort_remaining" class="mt-1 block w-full">
                    <option value="">None</option>
                    <option value="highest" {{ request('sort_remaining') == 'highest' ? 'selected' : '' }}>Highest</option>
                    <option value="lowest" {{ request('sort_remaining') == 'lowest' ? 'selected' : '' }}>Lowest</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>

    @if (count($transactions) > 0)
        <table class="table table-bordered w-full">
            <thead>
                <tr class="text-center text-sm gap-2">
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Amount Spent</th>
                    <th>Remaining Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $history)
                    <tr class="text-center text-sm gap-2">
                        <td>{{ $history->year }}</td>
                        <td>{{ $history->month_name }}</td>
                        <td>{{ $history->total_amount }}</td>
                        <td>{{ $history->remaining_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>There is no history for this budget. Come back next month!</p>
    @endif
</div>
@endsection
