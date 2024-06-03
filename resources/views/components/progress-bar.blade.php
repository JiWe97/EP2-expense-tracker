@php
    $totalBudget = $budget->amount;
    $totalSpent = "50";
    $percentage = ($totalSpent / $totalBudget) * 100;
@endphp

<div class="mb-4">
    <h1 class="text-black pr-10 pt-2 sm:pt-5 sm:pr-80 pt-5">
        <span class="text-xs text-grey-400">{{ round($percentage) }}%</span>
    </h1>
    <div class="flex mt-2 mr-10 sm:mr-80 h-4 relative w-60 rounded-full overflow-hidden">
        <div class="w-full h-full bg-gray-200 absolute"></div>
        <div class="h-full bg-yellow-400 sm:bg-green-500 absolute" style="width: {{ $percentage }}%"></div>
    </div>
</div>
