<?php

namespace App\Livewire\Components;

use Livewire\Component;

class OrderHistoryButton extends Component
{
    public function openOrderHistory()
    {
        $this->dispatch('toggle-order-history');
    }

    public function render()
    {
        return view('livewire.components.order-history-button');
    }
}