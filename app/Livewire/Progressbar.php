<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Transaction;

class Progressbar extends Component
{
    public $budget;
    public $transactions;
    public $percentage;
    public $colorClass;

    public function mount($budget, $transactions = null)
    {
        $this->budget = $budget;
        $this->filterTransactions($transactions ?? collect([]));
        $this->calculatePercentage();
    }


    public function refreshProgress()
    {
        // Re-fetch transactions that belong to the budget's categories
        $this->filterTransactions(Transaction::whereIn('category_id', $this->budget->categories->pluck('id'))->get());
        $this->calculatePercentage();
    }
    
    private function filterTransactions($transactions)
    {
        $budgetCategoryIds = $this->budget->categories->pluck('id');
        $this->transactions = $transactions->filter(function ($transaction) use ($budgetCategoryIds) {
            return $budgetCategoryIds->contains($transaction->category_id);
        });
    }

    public function calculatePercentage()
    {
        $totalBudget = $this->budget->amount;
        $totalSpent = $this->transactions->sum('amount');
        $this->percentage = $totalBudget > 0 ? ($totalSpent / $totalBudget) * 100 : 0;

        if ($this->percentage >= 100) {
            $this->colorClass = 'bg-red-500';
            Session::flash('alert', ['type' => 'danger', 'message' => 'Budget has reached 100%!']);
        } elseif ($this->percentage >= 80) {
            $this->colorClass = 'bg-orange-500';
            Session::flash('alert', ['type' => 'warning', 'message' => 'Budget has reached 80%!']);
        } else {
            $this->colorClass = 'bg-green-400';
        }
    }

    public function render()
    {
        return view('livewire.progressbar', [
            'transactions' => $this->transactions
        ]);
    }
}
