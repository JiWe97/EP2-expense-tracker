<?php

namespace App\Livewire;

use Livewire\Component;

class Colorpicker extends Component
{
    public $color;

    /**
     * Initialize the component.
     *
     * @param string $initialColor
     * @return void
     */
    public function mount($initialColor = '#ffffff')
    {
        $this->color = $initialColor;
    }

    /**
     * Update the color value.
     *
     * @param string $value
     * @return void
     */
    public function updatedColor($value)
    {
        $this->color = $value;
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.colorpicker');
    }
}
