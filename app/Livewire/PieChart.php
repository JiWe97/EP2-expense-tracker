<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PieChart extends Component
{
    public $categoryData;

    protected $listeners = ['updateChartData'];

    /**
     * Initialize the component with the given data.
     *
     * @param array $categoryData
     * @return void
     */
    public function mount($categoryData = [])
    {
        $this->categoryData = $categoryData;
    }

    /**
     * Update the chart data and log the update.
     *
     * @param array $data
     * @return void
     */
    public function updateChartData($data)
    {
        $this->categoryData = $data['categories'];
        Log::info('Pie chart data updated', ['categoryData' => $this->categoryData]);
        $this->dispatch('chartUpdated');
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.pie-chart');
    }
}
