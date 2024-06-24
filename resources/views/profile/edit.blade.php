<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- update profile information form -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white light:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        <!-- upload profile picure -->
            <div class="p-4 sm:p-8 bg-white light:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.upload-profile-picture-form')
                </div>
            </div>
        <!-- add bank form -->
            <div class="p-4 sm:p-8 bg-white light:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-100">
                    @include('profile.partials.add-bank-records')
                </div>
            </div>
        <!-- update password form -->
            <div class="p-4 sm:p-8 bg-white light:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        <!-- delete user form -->
            <div class="p-4 sm:p-8 bg-white light:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
