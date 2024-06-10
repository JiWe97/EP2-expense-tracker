<form method="POST" action="{{ route('update.banking.record.put', $bankingRecord) }}">
    @csrf
    @method('PUT')

     <div>
        <x-input-label for="bankName" value="{{ __('Bank Name') }}" />
        <x-text-input id="bankName" name="bank_name" type="text" class="mt-1 block w-full" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
    </div>

    <div>
        <x-input-label for="accountNumber" value="{{ __('Account Number') }}" />
        <x-text-input id="accountNumber" name="account_number" type="text" class="mt-1 block w-full" required />
        <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
    </div>

    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        {{ __('Update') }}
    </button>
</form>
