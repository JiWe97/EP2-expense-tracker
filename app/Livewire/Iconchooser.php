<?php

namespace App\Livewire;

use Livewire\Component;

class Iconchooser extends Component
{
    public $selectedIcon;
    public $icons = [
        'fas fa-paint-brush' => 'Paint Brush',
        'fas fa-car' => 'Car',
        'fas fa-users' => 'Users',
        'fas fa-utensils' => 'Utensils',
        'fas fa-home' => 'Home',
        'fas fa-heartbeat' => 'Heartbeat',
        'fas fa-shopping-basket' => 'Shopping Basket',
        'fas fa-book' => 'Book',
        'fas fa-plane' => 'Plane',
        'fas fa-file-invoice-dollar' => 'File Invoice Dollar',
        'fas fa-shopping-cart' => 'Shopping Cart',
        'fas fa-football-ball' => 'Football Ball',
        'fas fa-ellipsis-h' => 'Ellipsis H',
        'fas fa-paw' => 'Paw',
        'fas fa-home' => 'Home',
        'fas fa-film' => 'Film',
        'fas fa-bus' => 'Bus',
        'fas fa-shield-alt' => 'Shield Alt',
        'fas fa-briefcase' => 'Briefcase',
        'fas fa-money-bill-wave' => 'Money Bill Wave',
        'fas fa-percentage' => 'Percentage',
        'fas fa-chart-line' => 'Chart Line',
        'fas fa-hand-holding-usd' => 'Hand Holding USD',
        'fas fa-ticket-alt' => 'Ticket Alt',
        'fas fa-dice' => 'Dice',
        'fas fa-receipt' => 'Receipt',
        'fas fa-baby' => 'Baby',
        'fas fa-gift' => 'Gift',
    ];
    public function mount($initialIcon = null)
    {
        $this->selectedIcon = $initialIcon;
    }
    
    public function selectIcon($icon)
    {
        $this->selectedIcon = $icon;
    }

    public function render()
    {
        return view('livewire.iconchooser');
    }
}
