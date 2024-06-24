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
        'payoff' => ['except' => ''],
        'selectedBankIds' => ['except' => []]
    ];

    public function mount()
    {
        $this->selectedBankIds = [];
    }

    public function toggleBankSelection($bankId)
    {
        if (in_array($bankId, $this->selectedBankIds)) {
            $this->selectedBankIds = array_diff($this->selectedBankIds, [$bankId]);
        } else {
            $this->selectedBankIds[] = $bankId;
        }

        $this->resetPage();
        $this->search(); // Call search method to update charts
    }

    public function search()
    {
        $this->resetPage();

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
            ->when($this->category, function($query) {
                $query->where('category_id', $this->category);
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
            ->when($this->payoff, function($query) {
                $query->whereHas('payoff', function($q) {
                    $q->where('name', 'like', '%' . $this->payoff . '%');
                });
            })
            ->get();

        Log::info('Transactions found', ['transactions' => $transactions]);

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
                $query->where('category_id', $this->category);
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
            ->when($this->payoff, function($query) {
                $query->whereHas('payoff', function($q) {
                    $q->where('name', 'like', '%' . $this->payoff . '%');
                });
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
