<div>
    <div class="mb-4">
        <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
        <div class="grid grid-cols-6 gap-4">
            @foreach($icons as $iconClass => $iconName)
                <div class="flex items-center justify-center border cursor-pointer @if($selectedIcon === $iconClass) border-4 border-blue-500 @else border-gray-300 @endif" wire:click="selectIcon('{{ $iconClass }}')" style="height: 80px; width: 80px; border-radius: 50%;">
                    <i class="{{ $iconClass }} fa-2x"></i>
                </div>
            @endforeach
        </div>
    </div>
    @if ($selectedIcon)
        <input type="hidden" name="icon" value="{{ $selectedIcon }}">
    @endif
</div>
