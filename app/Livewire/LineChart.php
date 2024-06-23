<?php

namespace App\Livewire;

use Livewire\Component;

class LineChart extends Component
{
    public $labels;
    public $income;
    public $expense;
    public $balance;

    protected $listeners = ['refresh-chart' => 'updateChartData'];

    public function mount($labels, $income, $expense, $balance)
    {
        $this->labels = $labels;
        $this->income = $income;
        $this->expense = $expense;
        $this->balance = $balance;
    }

    public function updateChartData($data)
    {
        $this->labels = $data['labels'];
        $this->income = $data['income'];
        $this->expense = $data['expense'];
        $this->balance = $data['balance'];
        $this->dispatchSelf('chartUpdated');
    }

    public function render()
    {
        return view('livewire.line-chart');
    }
}
