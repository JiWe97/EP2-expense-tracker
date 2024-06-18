<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;

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

    protected $queryString = [
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'category' => ['except' => ''],
        'type' => ['except' => ''],
        'description' => ['except' => ''],
        'amount' => ['except' => ''],
        'banking_record' => ['except' => ''],
        'payoff' => ['except' => '']
    ];

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->reset(['start_date', 'end_date', 'category', 'type', 'description', 'amount', 'banking_record', 'payoff']);
        $this->dispatch('reset-search-form');
        $this->search();
    }

    public function render()
    {
        $transactions = Transaction::query()
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
            ->when($this->banking_record, function($query) {
                $query->whereHas('bankingRecord', function($q) {
                    $q->where('bank_name', 'like', '%' . $this->banking_record . '%');
                });
            })
            ->when($this->payoff, function($query) {
                $query->whereHas('payoff', function($q) {
                    $q->where('name', 'like', '%' . $this->payoff . '%');
                });
            })
            ->paginate(10);

        return view('livewire.transaction-search', [
            'transactions' => $transactions,
        ]);
    }
}
