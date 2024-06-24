<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Transactions') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form id="upload-form" action="{{ route('transactions.preview') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                        Upload CSV File
                    </label>
                    <input type="file" name="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('file')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="back-link">
                        Preview
                    </button>
                </div>
            </form>

            @if(session('fileContent'))
                <form action="{{ route('transactions.import') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_path" value="{{ session('filePath') }}">
                    <div class="flex items-center justify-between mt-4">
                        <button type="submit" class="edit-custom-btn">
                            Confirm and Import
                        </button>
                    </div>
                </form>
                <h3 class="text-xl font-bold mt-6">File Preview:</h3>
                <div class="overflow-auto">
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                @foreach(session('fileContent')[0] as $header)
                                    <th class="px-4 py-2">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice(session('fileContent'), 1) as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td class="border px-4 py-2">{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="{{ route('transactions.import') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_path" value="{{ session('filePath') }}">
                    <div class="flex items-center justify-between mt-4">
                        <button type="submit" class="edit-custom-btn">
                            Confirm and Import
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
