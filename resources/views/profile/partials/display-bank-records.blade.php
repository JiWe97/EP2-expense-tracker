<div class="bg-white shadow-md rounded-lg p-6 m-8">
        <h2 class="text-xl font-semibold">{{ __('Banking Information') }}</h2>
        @foreach($user->bankingRecords as $record)
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h3 class="text-lg font-semibold">{{ $record->bank_name }}</h3>
        <p>{{ $record->account_number }}</p>

        
        <!-- Delete Button -->
        <form method="POST" action="{{ route('delete.banking.record', $record) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Delete') }}
            </button>
        </form>
    </div>
        @endforeach
    </div>