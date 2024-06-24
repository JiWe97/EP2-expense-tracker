<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PieChart extends Component
{
    public $categoryData;

    protected $listeners = ['updateChartData'];

    public function mount($categoryData = [])
    {
        $this->categoryData = $categoryData;
    }

    public function updateChartData($data)
    {
        $this->categoryData = $data['categories'];
        Log::info('Pie chart data updated', ['categoryData' => $this->categoryData]);
        $this->dispatch('chartUpdated');
    }

    public function render()
    {
        return view('livewire.pie-chart');
    }
}
