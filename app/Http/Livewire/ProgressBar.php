<?php 

namespace App\Http\Livewire;

use Livewire\Component;

class ProgressBar extends Component
{
    public $budget;
    public $transactions;
    public $percentage;
    public $colorClass;

    public function mount($budget, $transactions)
    {
        $this->budget = $budget;
        $this->transactions = $transactions;
        $this->calculatePercentage();
    }

    public function calculatePercentage()
    {
        $totalBudget = $this->budget->amount;
        $totalSpent = $this->transactions->sum('amount');
        $this->percentage = $totalBudget > 0 ? ($totalSpent / $totalBudget) * 100 : 0;

        if ($this->percentage >= 100) {
            $this->colorClass = 'bg-red-500';
            $this->dispatchBrowserEvent('alert', ['type' => 'danger', 'message' => 'Budget has reached 100%!']);
        } elseif ($this->percentage >= 80) {
            $this->colorClass = 'bg-orange-500';
            $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'Budget has reached 80%!']);
        } else {
            $this->colorClass = 'bg-yellow-400';
        }
    }

    public function render()
    {
        return view('livewire.progress-bar');
    }
}
