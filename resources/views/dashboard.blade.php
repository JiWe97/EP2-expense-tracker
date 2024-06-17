<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="flex">
        <!-- Vertical Navbar -->
        <nav class="w-1/6 text-white bg-gray-200 dark:bg-gray-800 h-screen">
            <!-- Navbar content goes here -->
            <!-- Example: -->
            <ul class="p-4">
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li><a href="{{ route('budgets.index') }}">Budgets</a></li>
                <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                <li><a href="{{ route('goals.index') }}">Goals</a></li>
            </ul>
        </nav>
        <div class="w-5/6 p-8 text-white">
            @if($bankingRecords->isNotEmpty())
            <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Total Balance: {{ $totalBalance }}</h2>
                </div>
                <button id="toggleAll" class="btn btn-primary">Show All</button>
                @foreach($bankingRecords as $record)
                    <div class="mb-4">
                        <a href="#" onclick="toggleDetails({{ $record->id }})"><h4 class="text-lg font-bold mb-2">{{ $record->bank_name }}</h4></a>
                        <span id="details-{{ $record->id }}" style="display:none;"><p><strong>Account Number:</strong> {{ $record->account_number }}</p>
                        <p><strong>Balance:</strong> {{ $record->balance }}</p></span>
                    </div>
                @endforeach
            @else
                <p>No banking information found.</p>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
function toggleDetails(id) {
    var detailElement = document.getElementById('details-' + id);
    if (detailElement.style.display === 'none') {
        detailElement.style.display = 'block';
    } else {
        detailElement.style.display = 'none';
    }
}

document.getElementById('toggleAll').addEventListener('click', function() {
    var detailsElements = document.querySelectorAll('[id^="details-"]');
    detailsElements.forEach(function(element) {
        if (element.style.display === 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    });
    this.innerText = this.innerText === 'Show All'? 'Close All' : 'Show All';
});
</script>