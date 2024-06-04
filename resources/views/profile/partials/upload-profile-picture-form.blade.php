<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Upload Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your account\'s profile picture.') }}
        </p>
    </header>

    <!-- Check if user already has a profile picture -->
    @if($user->profilepicture)
        <img src="{{ Storage::url($user->profilepicture) }}" alt="User Profile Picture" class="h-20 w-20 object-scale-down rounded-full mt-4">
    @endif

    <form method="POST" action="/uploads" enctype="multipart/form-data" class="mt-6 space-y-6">
    @csrf
    <div class="flex items-center justify-between">
        <input type="file" name="my_file" id="my_file" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-300">
    </div>
    <button type="submit" class="mt-2 inline-flex justify-center py-2 px-4 border border-solid shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Upload File
    </button>
</form>

</section>