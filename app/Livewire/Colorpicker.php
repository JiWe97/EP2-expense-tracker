<?php

namespace App\Livewire;

use Livewire\Component;

class Colorpicker extends Component
{
    public $color;

    public function mount($initialColor = '#ffffff')
    {
        $this->color = $initialColor;
    }

    public function updatedColor($value)
    {
        $this->color = $value;
    }

    public function render()
    {
        return view('livewire.colorpicker');
    }
}
