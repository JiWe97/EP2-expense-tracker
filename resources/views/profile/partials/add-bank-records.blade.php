<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Bank Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Add your bank records.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('store.banking.record') }}" class="mt-6 space-y-6">
        @csrf
        
        <div>
        <label for="bankName">Bank Name:</label>
        <input type="text" id="bankName" name="bank_name" required>
    </div>
    <div>
        <label for="accountNumber">Account Number:</label>
        <input type="text" id="accountNumber" name="account_number" required>
    </div>
    <button type="submit">Save</button>
    </form>
</section>