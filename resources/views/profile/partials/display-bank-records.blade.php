<div class="bg-white shadow-md rounded-lg p-6 m-8">
        <h2 class="text-xl font-semibold">{{ __('Banking Information') }}</h2>
        @foreach($user->bankingRecords as $record)
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h3 class="text-lg font-semibold">{{ $record->name }}</h3>
        <p>{{ $record->bank_name }}</p>
        <p>{{ $record->account_number }}</p>
        <p>{{ $record->balance }}</p>

        <!-- Edit Button -->
        <a href="#" onclick="event.preventDefault(); editForm('{{ $record->id }}');" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('Edit') }}
        </a>

        <!-- Hidden Edit Form -->
        <div id="edit-form-{{ $record->id }}" style="display:none;" class="m-4">
            <form method="POST" action="{{ route('update.banking.record.put', $record) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Bank Name -->
                <div>
                    <input type="hidden" name="banking_record_id" value="{{ $record->id }}">
                    <x-input-label for="bankName" value="{{ __('Bank Name') }}" />
                    <x-text-input id="bankName" name="bank_name" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                </div>


                <!-- Account Number -->
                <div>
                    <x-input-label for="accountNumber" value="{{ __('Account Number') }}" />
                    <x-text-input id="accountNumber" name="account_number" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
                </div>

                <!-- Balance -->
                <div>
                    <x-input-label for="balance" value="{{ __('Balance') }}" />
                    <x-text-input id="balance" name="balance" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('balance')" />
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Update') }}
                </button>
            </form>
        </div>
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

    <script>
function editForm(recordId) {
    var formContainer = document.getElementById('edit-form-' + recordId);
    if (formContainer.style.display === 'none') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
}
</script>