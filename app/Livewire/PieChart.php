<?php

namespace App\Livewire;

use Livewire\Component;

class PieChart extends Component
{
    public $categoryData;

    protected $listeners = ['refresh-chart' => 'updateChartData'];

    public function mount($categoryData)
    {
        $this->categoryData = $categoryData;
    }

    public function updateChartData($data)
    {
        $this->categoryData = $data['categories'];
        $this->dispatchSelf('chartUpdated');
    }

    public function render()
    {
        return view('livewire.pie-chart');
    }
}
