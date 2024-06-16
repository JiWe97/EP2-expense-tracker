<div x-data="{ color: @entangle('color') }">
    <div class="mb-4">
        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
        <div class="relative w-10 h-10">
            <input type="color" x-model="color" id="color" name="color" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">
            <div class="w-full h-full border rounded" :style="{ 'background-color': color }"></div>
        </div>
        @error('color')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <input type="hidden" name="color" x-model="color">
</div>
