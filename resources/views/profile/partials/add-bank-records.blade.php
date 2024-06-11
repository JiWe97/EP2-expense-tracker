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
        <x-input-label for="bankName" value="{{ __('Bank Name') }}" />
        <x-text-input id="bankName" name="bank_name" type="text" class="mt-1 block w-full" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
    </div>

    <div>
        <x-input-label for="accountNumber" value="{{ __('Account Number') }}" />
        <x-text-input id="accountNumber" name="account_number" type="text" class="mt-1 block w-full" required />
        <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
    </div>

     <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
        
    </form>

    <!--Display bank records here-->
    @include('profile.partials.display-bank-records')

</section>