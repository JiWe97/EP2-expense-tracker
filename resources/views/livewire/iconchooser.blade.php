<div>
    <div class="mb-4">
        <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
        <div class="grid grid-cols-6 gap-4 justify-center"> <!-- Center the grid -->
            @foreach($icons as $iconClass => $iconName)
                <div 
                    class="flex items-center justify-center border cursor-pointer m-2
                    @if($selectedIcon === $iconClass) border-4 border-blue-500 @else border-gray-300 @endif" 
                    wire:click="selectIcon('{{ $iconClass }}')" 
                    style="height: 65px; width: 65px; border-radius: 50%; margin: 5px">
                    <i class="{{ $iconClass }} fa-2x"></i>
                </div>
            @endforeach
        </div>
    </div>
    @if ($selectedIcon)
        <input type="hidden" name="icon" value="{{ $selectedIcon }}">
    @endif
</div>
