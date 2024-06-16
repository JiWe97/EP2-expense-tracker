<div class="container">
    @push('styles')
        @include('layouts.styles')
    @endpush
    
    <div x-data="{ open: false }">
        <button @click="open = true" class="btn-custom">Delete</button>

        <div x-show="open" @click.away="open = false" class="modal">
            <div class="modal-content">
                <span @click="open = false" class="close">&times;</span>
                <form wire:submit.prevent="deleteCategory">
                    <div class="mb-4">
                        <label for="new_category_id" class="block text-sm font-medium text-gray-700">
                            Select new category for existing transactions or press delete to keep the category in your history:
                        </label>
                        <select wire:model="newCategoryId" id="new_category_id" name="new_category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-custom">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
