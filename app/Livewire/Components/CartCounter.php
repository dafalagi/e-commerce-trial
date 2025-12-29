<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    public $item_count = 0;

    public function mount()
    {
        $this->loadCartCount();
    }

    #[On('cart-count-updated')]
    public function updateCartCount($count)
    {
        $this->item_count = $count;
    }

    #[On('cart-updated')]
    public function loadCartCount()
    {
        if (!Auth::check()) {
            $this->item_count = 0;
            return;
        }

        try {
            $result = app('GetCartService')->execute([
                'user_id' => Auth::user()->id,
                'status' => 'active',
                'with' => ['cartItems']
            ], true);

            if ($result['data']->isNotEmpty()) {
                $cart = $result['data']->first();
                $this->item_count = $cart->cartItems->sum('quantity');
            } else {
                $this->item_count = 0;
            }
        } catch (\Exception $e) {
            $this->item_count = 0;
        }
    }

    public function openCart()
    {
        $this->dispatch('toggle-cart-modal');
    }

    public function render()
    {
        return view('livewire.components.cart-counter');
    }
}