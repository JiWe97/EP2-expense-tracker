<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Goal;

class GoalProgress extends Component
{
    public $goal;
    public $progress;
    public $colorClass;
    public $totalSaved;
    public $remaining;

    /**
     * Mount the component with the given goal.
     *
     * @param Goal $goal
     * @return void
     */
    public function mount(Goal $goal)
    {
        $this->goal = $goal;
        $this->calculateProgress();
        $this->totalSaved = $this->goal->goalTransactions()->sum('amount');
        $this->remaining = $this->goal->amount - $this->totalSaved;
    }

    /**
     * Calculate the progress of the goal.
     *
     * @return void
     */
    public function calculateProgress()
    {
        $totalAmount = $this->goal->amount;
        $currentAmount = $this->goal->goalTransactions()->sum('amount');

        $this->progress = ($totalAmount > 0) ? ($currentAmount / $totalAmount) * 100 : 0;

        // Determine color class based on progress
        if ($this->progress < 50) {
            $this->colorClass = 'bg-green-600';
        } elseif ($this->progress < 75) {
            $this->colorClass = 'bg-orange-500';
        } else {
            $this->colorClass = 'bg-yellow-600';
        }
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.goal-progress');
    }
}
