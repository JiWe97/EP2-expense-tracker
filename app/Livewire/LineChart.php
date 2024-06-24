<?php

namespace App\Livewire;

use Livewire\Component;

class LineChart extends Component
{
    public $labels;
    public $income;
    public $expense;
    public $balance;

    protected $listeners = ['updateChartData'];

    /**
     * Initialize the component with the given data.
     *
     * @param array $labels
     * @param array $income
     * @param array $expense
     * @param array $balance
     * @return void
     */
    public function mount($labels = [], $income = [], $expense = [], $balance = [])
    {
        $this->labels = $labels;
        $this->income = $income;
        $this->expense = $expense;
        $this->balance = $balance;
    }

    /**
     * Update the chart data and dispatch an event.
     *
     * @param array $data
     * @return void
     */
    public function updateChartData($data)
    {
        $this->labels = $data['labels'];
        $this->income = $data['income'];
        $this->expense = $data['expense'];
        $this->balance = $data['balance'];
        $this->dispatch('chartUpdated');
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.line-chart');
    }
}
