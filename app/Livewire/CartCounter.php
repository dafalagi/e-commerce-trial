<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCounter extends Component
{
    // This attribute tells Livewire to re-render this component
    // whenever the 'cart-updated' event is dispatched anywhere in the app.
    #[On('cart-updated')] 
    public function updateCount()
    {
        // This method doesn't need to do anything specifically,
        // calling it triggers the render() method automatically.
    }

    public function render()
    {
        $count = 0;

        if (Auth::check()) {
            // Count total items (sum of quantities)
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        }

        return view('livewire.cart-counter', [
            'count' => $count
        ]);
    }
}
