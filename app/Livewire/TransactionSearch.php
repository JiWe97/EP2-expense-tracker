<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Models\BankingRecord;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransactionSearch extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;
    public $category;
    public $type;
    public $description;
    public $amount;
    public $banking_record;
    public $payoff;
    public $selectedBankIds = [];
    public $totalBalance;

    protected $listeners = ['toggleBankSelection', 'search'];

    protected $queryString = [
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'category' => ['except' => ''],
        'type' => ['except' => ''],
        'description' => ['except' => ''],
        'amount' => ['except' => ''],
        'banking_record' => ['except' => ''],
        'payoff' => ['except' => ''],
        'selectedBankIds' => ['except' => []]
    ];

    public function mount()
    {
        /* $this->start_date = Carbon::now()->startOfMonth()->toDateString();
        $this->end_date = Carbon::now()->toDateString(); */
        $this->selectedBankIds = [];
        Log::info('Mounting component with initial selectedBankIds', ['selectedBankIds' => $this->selectedBankIds]);
    }

    public function toggleBankSelection($bankId)
    {
        Log::info('Received toggleBankSelection event', ['bankId' => $bankId]);

        if (in_array($bankId, $this->selectedBankIds)) {
            $this->selectedBankIds = array_diff($this->selectedBankIds, [$bankId]);
        } else {
            $this->selectedBankIds[] = $bankId;
        }

        Log::info('Toggled bank selection', ['bankId' => $bankId, 'selectedBankIds' => $this->selectedBankIds]);

        $this->resetPage();
        $this->search(); // Call search method to update charts
    }

    public function search()
    {
        $this->resetPage();

        // Fetch transactions based on filters
        $transactions = Transaction::where('user_id', Auth::id())
            ->when($this->start_date, function($query) {
                $query->where('date', '>=', $this->start_date);
            })
            ->when($this->end_date, function($query) {
                $query->where('date', '<=', $this->end_date);
            })
            ->when(!empty($this->selectedBankIds), function($query) {
                $query->whereIn('banking_record_id', $this->selectedBankIds);
            })
            ->get();

        // Prepare chart data
        $labels = [];
        $income = [];
        $expense = [];
        $categoryData = [];
        $balance = [];

        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $dateRange = [];

        // Create date range array
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->format('Y-m-d');
        }

        $cumulativeBalance = 0;
        foreach ($dateRange as $date) {
            $labels[] = $date;
            $dailyIncome = $transactions->where('date', $date)->where('type', 'income')->sum('amount');
            $dailyExpense = $transactions->where('date', $date)->where('type', 'expense')->sum('amount');
            $income[] = $dailyIncome;
            $expense[] = $dailyExpense;
            $cumulativeBalance += $dailyIncome - $dailyExpense;
            $balance[] = $cumulativeBalance;

            foreach ($transactions->where('date', $date)->where('type', 'expense') as $transaction) {
                if (isset($categoryData[$transaction->category->name])) {
                    $categoryData[$transaction->category->name] += $transaction->amount;
                } else {
                    $categoryData[$transaction->category->name] = $transaction->amount;
                }
            }
        }

        // Dispatch new data for charts
        $chartData = [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance,
            'categories' => $categoryData,
        ];

        $this->dispatch('searchUpdated', $chartData);
    }

    public function clear()
    {
        $this->reset([
            'start_date', 
            'end_date', 
            'category', 
            'type', 
            'description', 
            'amount', 
            'banking_record', 
            'payoff', 
            'selectedBankIds'
        ]);
        $this->dispatch('reset-search-form');
        $this->search();
    }

    public function render()
    {
        $userId = Auth::id();
        $transactions = Transaction::query()
            ->where('user_id', $userId)
            ->when($this->start_date, function($query) {
                $query->where('date', '>=', $this->start_date);
            })
            ->when($this->end_date, function($query) {
                $query->where('date', '<=', $this->end_date);
            })
            ->when($this->category, function($query) {
                $query->whereHas('category', function($q) {
                    $q->where('name', 'like', '%' . $this->category . '%');
                });
            })
            ->when($this->type, function($query) {
                $query->where('type', $this->type);
            })
            ->when($this->description, function($query) {
                $query->where('description', 'like', '%' . $this->description . '%');
            })
            ->when($this->amount, function($query) {
                $query->where('amount', $this->amount);
            })
            ->when(!empty($this->selectedBankIds), function($query) {
                $query->whereIn('banking_record_id', $this->selectedBankIds);
            })
            ->orderBy('date', 'desc')
            ->paginate(10);

        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $categories = Category::all(); // Fetch categories

        if (!empty($this->selectedBankIds)) {
            $this->totalBalance = $bankingRecords->whereIn('id', $this->selectedBankIds)->sum('balance');
        } else {
            $this->totalBalance = $bankingRecords->sum('balance');
        }

        // Prepare chart data for initial load
        $labels = [];
        $income = [];
        $expense = [];
        $categoryData = [];
        $balance = [];

        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $dateRange = [];

        // Create date range array
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->format('Y-m-d');
        }

        $cumulativeBalance = 0;
        foreach ($dateRange as $date) {
            $labels[] = $date;
            $dailyIncome = $transactions->where('date', $date)->where('type', 'income')->sum('amount');
            $dailyExpense = $transactions->where('date', $date)->where('type', 'expense')->sum('amount');
            $income[] = $dailyIncome;
            $expense[] = $dailyExpense;
            $cumulativeBalance += $dailyIncome - $dailyExpense;
            $balance[] = $cumulativeBalance;

            foreach ($transactions->where('date', $date)->where('type', 'expense') as $transaction) {
                if (isset($categoryData[$transaction->category->name])) {
                    $categoryData[$transaction->category->name] += $transaction->amount;
                } else {
                    $categoryData[$transaction->category->name] = $transaction->amount;
                }
            }
        }

        $chartData = [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance,
            'categories' => $categoryData,
        ];

        Log::info('Rendering component with transactions', ['transactions' => $transactions->items(), 'selectedBankIds' => $this->selectedBankIds]);

        return view('livewire.transaction-search', [
            'totalBalance' => $this->totalBalance,
            'transactions' => $transactions,
            'selectedBankIds' => $this->selectedBankIds,
            'bankingRecords' => $bankingRecords,
            'chartData' => $chartData,
            'categories' => $categories, // Pass categories to the view
        ]);
    }
}
