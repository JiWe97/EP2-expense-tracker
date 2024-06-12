@extends('layouts.custom')

@section('content')
<div class="container">
    <a href="{{ route('budgets.show', ['budget' => $budget->id]) }}" class="link mb-5">Back</a>
    <h1 class="text-xl font-bold mb-5">History for {{ $budget->name }}</h1>
        @if (count($transactions) > 0)
        <table class="table table-bordered w-full">
            <thead>
                <tr class="text-center text-sm gap-2">
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($transactions as $history)
                        <tr class="text-center text-sm gap-2">
                            <td>{{ $history->year }}</td>
                            <td>{{ $history->month }}</td>
                            <td>{{ $history->total_amount }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <p>There is no history for this budget. Come back next month! </p>
    @endif
</div>


@endsection
