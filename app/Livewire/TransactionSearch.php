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
    public $categoryTotals;
    public $transactionData;
    public $balanceArr;

    protected $listeners = ['toggleBankSelection'];

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
        $this->selectedBankIds = [];
        Log::info('Mounting component with initial selectedBankIds', ['selectedBankIds' => $this->selectedBankIds]);
        $this->recalculateData();
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
        $this->recalculateData();
    }

    public function search()
    {
        $this->resetPage();
        $this->recalculateData();
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

    public function recalculateData()
    {
        $userId = Auth::id();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $query = Transaction::query()
            ->where('user_id', $userId)
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd]) // Only include transactions from the current month
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
            });

        $transactions = $query->get();

        // Calculate category totals
        $expenseTransactions = $transactions->filter(function ($transaction) {
            return $transaction->type === 'expense';
        });

        $this->categoryTotals = $expenseTransactions->groupBy('category_id')->map(function ($categoryTransactions) {
            return $categoryTransactions->sum('amount') * -1;
        });

        // Pre-fetch categories to avoid multiple queries
        $categories = Category::whereIn('id', $this->categoryTotals->keys())->pluck('name', 'id');

        // Map category IDs to category names and keep the totals
        $this->categoryTotals = $this->categoryTotals->mapWithKeys(function ($total, $categoryId) use ($categories) {
            $name = $categories->get($categoryId, 'Unknown Category');
            return [$name => $total];
        });

        // Calculate balance and transaction history
        $latestBankingRecord = BankingRecord::where('user_id', $userId)->latest()->first();
        $balance = $latestBankingRecord ? $latestBankingRecord->balance : 0;
        $balanceArr = [];
        $transactionReverse = $transactions->reverse();
        foreach ($transactionReverse as $transaction) {
            $difference = $transaction->amount;
            $balance += $difference;
            $balanceArr[] = $balance;
        }
        $this->balanceArr = array_reverse($balanceArr);

        // Map transaction types for graph
        $this->transactionData = $transactions->map(function ($transaction) {
            return [
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'date' => $transaction->date,
            ];
        })->sortBy('date')->values()->toArray();

        // Dispatch event to render graphs
        $this->dispatch('renderGraph', [
            'categoryTotals' => $this->categoryTotals,
            'transactionData' => $this->transactionData,
            'balanceArr' => $this->balanceArr
        ]);
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

        if (!empty($this->selectedBankIds)) {
            $this->totalBalance = $bankingRecords->whereIn('id', $this->selectedBankIds)->sum('balance');
        } else {
            $this->totalBalance = $bankingRecords->sum('balance');
        }

        Log::info('Rendering component with transactions', ['transactions' => $transactions->items(), 'selectedBankIds' => $this->selectedBankIds]);

        return view('livewire.transaction-search', [
            'totalBalance' => $this->totalBalance,
            'categoryTotals' => $this->categoryTotals,
            'transactionData' => $this->transactionData,
            'balanceArr' => $this->balanceArr,
            'transactions' => $transactions,
            'selectedBankIds' => $this->selectedBankIds,
            'bankingRecords' => $bankingRecords,
        ]);
    }
}
