<div>
    <div class="mb-4">
        <div class="mb-4">
            <p>Total Saved: € {{ $goal->goal_transactions()->sum('amount') }}</p>
            <p>Remaining: € {{ $goal->amount - $goal->goal_transactions()->sum('amount') }}</p>
        </div>
        <div class="mb-4">
            <h1 class="text-black pr-10 pt-2 sm:pt-5">
                <span class="text-xs text-grey-400">{{ round($progress) }}%</span>
            </h1>
            <div class="flex mt-2 mr-10 sm:mr-80 h-4 relative w-60 rounded-full overflow-hidden">
                <div class="w-full h-full bg-gray-200 absolute"></div>
                <div class="h-full absolute {{ $colorClass }}" style="width: {{ $progress }}%"></div>
            </div>
        </div>
    </div>

</div>
