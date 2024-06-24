<style>
.delete-btn {
    padding: 8px 16px;
        background-color: #b87a9a;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
}

.delete-btn:hover {
    background-color: #ffffff;
    color: #b87a9a;
}

.edit-btn {
    display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
}

.edit-btn:hover {
    background-color: #ffffff;
    color: #A3BE84;
}

.update-btn {
     display: inline-block;
        padding: 8px 16px;
        background-color: #7a9ab8;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
}

.update-btn:hover {
    background-color: #ffffff;
    color: #7a9ab8;
}

</style>

<div class="bg-white p-6 m-8">
    <h2 class="text-xl font-semibold mb-4">{{ __('Banking Information') }}</h2>
    @foreach($user->bankingRecords as $record)
        <div class="bg-white shadow-md rounded-lg p-6 mb-4 max-w-lg">
            <h3 class="text-lg font-semibold">{{ $record->name }}</h3>
            <p>{{ $record->bank_name }}</p>
            <p>{{ $record->account_number }}</p>
            <p>&#8364; {{ $record->balance }}</p>

            <!-- Edit Button -->
            <div class="m-2 flex">
                <a href="#" onclick="event.preventDefault(); editForm('{{ $record->id }}', '{{ $record->name }}', '{{ $record->bank_name }}', '{{ $record->account_number }}', '{{ $record->balance }}');" class="mb-2 mr-2 edit-btn">
                    {{ __('Edit') }}
                </a>
                <form method="POST" action="{{ route('delete.banking.record', $record) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>

            <!-- Hidden Edit Form -->
<div id="edit-form-{{ $record->id }}" style="display:none;" class="m-4">
    <form method="POST" action="{{ route('update.banking.record.put', $record) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <x-input-label for="name" value="{{ __('Name') }}" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus value="{{ old('name', $record->name) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Bank Name -->
        <div>
            <input type="hidden" name="banking_record_id" value="{{ $record->id }}">
            <x-input-label for="bankName" value="{{ __('Bank Name') }}" />
            <x-text-input id="bankName" name="bank_name" type="text" class="mt-1 block w-full" required autofocus value="{{ old('bank_name', $record->bank_name) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
        </div>

        <!-- Account Number -->
        <div>
            <x-input-label for="accountNumber" value="{{ __('Account Number') }}" />
            <x-text-input id="accountNumber" name="account_number" type="text" class="mt-1 block w-full" required value="{{ old('account_number', $record->account_number) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
        </div>

        <!-- Balance -->
        <div>
            <x-input-label for="balance" value="{{ __('Balance') }}" />
            <x-text-input id="balance" name="balance" type="text" class="mt-1 block w-full" required value="{{ old('balance', $record->balance) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('balance')" />
        </div>

        <button type="submit" class="mt-2 update-btn">
            {{ __('Update') }}
        </button>
    </form>
</div>
        </div>
    @endforeach
</div>

<script>
function editForm(recordId, name, bankName, accountNumber, balance) {
    var formContainer = document.getElementById('edit-form-' + recordId);
    if (formContainer.style.display === 'none') {
        formContainer.style.display = 'block';

        // Set input values
        document.getElementById('name').value = name;
        document.getElementById('bankName').value = bankName;
        document.getElementById('accountNumber').value = accountNumber;
        document.getElementById('balance').value = balance;
    } else {
        formContainer.style.display = 'none';
    }
}
</script>