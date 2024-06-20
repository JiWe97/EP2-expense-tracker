<div>
    <h2 class="text-lg font-medium text-gray-450">Progress</h2>
    <p class="progress-info flex justify-end mr-4">Saved € {{$totalSaved}} / € {{$goal->amount}}</p>
    <div class="flex justify-between items-center">
        <div class="flex-grow mr-4">
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: {{ $progress }}%"></div>
            </div>
        </div>
    </div>
    <p class="progress-text mt-2">{{ round($progress) }}%</p>
</div>
