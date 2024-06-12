<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\Transaction;
use App\Models\Budget;
use App\Mail\PartiallySpent;
use App\Mail\CompletelySpent;

class Progressbar extends Component
{
    public $budget;
    public $transactions;
    public $percentage;
    public $colorClass;

    public function mount($budgetId)
    {
        $this->budget = Budget::with(['bankingRecord.user', 'categories'])->findOrFail($budgetId);
        $this->refreshProgress();
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

            if ($this->shouldSendCompleteNotification()) {
                Mail::to($this->budget->bankingRecord->user->email)->send(new CompletelySpent($this->budget, $this->transactions));
                $this->budget->last_completely_spent_notification = now();
                $this->budget->save();
            }
        } elseif ($this->percentage >= 80) {
            $this->colorClass = 'bg-orange-500';
            Session::flash('alert', ['type' => 'warning', 'message' => 'Budget has reached 80%!']);
            
            if ($this->shouldSendPartialNotification()) {
                Mail::to($this->budget->bankingRecord->user->email)->send(new PartiallySpent($this->budget, $this->transactions));
                $this->budget->last_partially_spent_notification = now();
                $this->budget->save();
            }
        } else {
            $this->colorClass = 'bg-green-400';
        }
    }

    private function shouldSendPartialNotification()
    {
        $lastNotification = $this->budget->last_partially_spent_notification;

        return $this->budget->mail_when_partially_spent && $this->budget->bankingRecord && $this->budget->bankingRecord->user &&
            (!$lastNotification || $lastNotification->lt(now()->subMonth()));
    }

    private function shouldSendCompleteNotification()
    {
        $lastNotification = $this->budget->last_completely_spent_notification;

        return $this->budget->mail_when_completely_spent && $this->budget->bankingRecord && $this->budget->bankingRecord->user &&
            (!$lastNotification || $lastNotification->lt(now()->subMonth()));
    }

    public function render()
    {
        return view('livewire.progressbar', [
            'transactions' => $this->transactions
        ]);
    }
}
