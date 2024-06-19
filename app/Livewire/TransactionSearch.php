<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Models\BankingRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    }

    public function search()
    {
        $this->resetPage();
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

        if (!empty($this->selectedBankIds)) {
            $totalBalance = $bankingRecords->whereIn('id', $this->selectedBankIds)->sum('balance');
        } else {
            $totalBalance = $bankingRecords->sum('balance');
        }

        Log::info('Rendering component with transactions', ['transactions' => $transactions->items(), 'selectedBankIds' => $this->selectedBankIds]);

        return view('livewire.transaction-search', [
            'transactions' => $transactions,
            'selectedBankIds' => $this->selectedBankIds,
            'bankingRecords' => $bankingRecords,
            'totalBalance' => $totalBalance,
        ]);
    }
}
