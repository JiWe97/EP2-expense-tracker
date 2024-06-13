<div class="w-64 h-screen bg-gray-800 text-white fixed left-0 top-0 flex flex-col">
    <div class="flex items-center p-4">
        <img src="{{ Storage::url(Auth::user()->profilepicture) }}" alt="Profile Picture" class="w-16 h-16 rounded-full mr-4">
        <div>
            <p class="font-bold">{{ Auth::user()->name }}</p>
        </div>
    </div>
    <nav class="flex flex-col mt-4">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        <a href="{{ route('categories.index') }}" class="nav-link">Categories</a>
        <a href="{{ route('transactions.index') }}" class="nav-link">Transactions</a>
        <a href="{{ route('budgets.index') }}" class="nav-link">Budgets</a>
        <a href="{{ route('goals.index') }}" class="nav-link">Goals</a>
    </nav>
</div>

<style>
    .nav-link {
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .nav-link:hover {
        background-color: #4a4a4a;
    }
</style>
