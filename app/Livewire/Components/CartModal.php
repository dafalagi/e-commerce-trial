<?php

namespace App\Livewire\Components;

use App\Enums\Order\CartStatus;
use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CartModal extends Component
{
    use WithToast;

    public $is_open = false;
    public $cart = null;
    public $cart_items;
    public $total_amount = 0;
    public $item_count = 0;

    public function mount()
    {
        $this->loadCart();
    }

    #[On('cart-updated')]
    public function loadCart()
    {
        if (!Auth::check()) {
            $this->cart = null;
            $this->cart_items = collect();
            $this->total_amount = 0;
            $this->item_count = 0;
            return;
        }

        $result = app('GetCartService')->execute([
            'user_uuid' => Auth::user()->uuid,
            'status' => CartStatus::ACTIVE->value,
            'with' => ['cartItems.product']
        ], true);

        if ($result['data']->isNotEmpty()) {
            $this->cart = $result['data']->first();
            $this->cart_items = app('GetCartItemService')->execute([
                'cart_uuid' => $this->cart->uuid,
                'sort_by' => 'created_at',
                'sort_type' => 'asc',
                'with' => ['product']
            ])['data'];

            $this->calculateTotals();
        } else {
            $this->cart = null;
            $this->cart_items = collect();
            $this->total_amount = 0;
            $this->item_count = 0;
        }

        $this->dispatch('cart-count-updated', count: $this->item_count);
    }

    #[On('toggle-cart-modal')]
    public function toggleModal()
    {
        $this->is_open = !$this->is_open;
        
        if ($this->is_open) {
            $this->loadCart();
        }
    }

    public function closeModal()
    {
        $this->is_open = false;
    }

    public function updateQuantity($cart_item_uuid, $quantity)
    {
        DB::beginTransaction();
        try {
            $cart_item = $this->cart_items->firstWhere('uuid', $cart_item_uuid);
            
            app('UpdateCartItemService')->execute([
                'cart_item_uuid' => $cart_item_uuid,
                'quantity' => $quantity,
                'price' => $cart_item->price,
                'total_price' => $quantity * $cart_item->price,
                'version' => $cart_item->version
            ], true);

            $this->loadCart();
            $this->showSuccessToast('Cart updated successfully!');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage() ?: 'Failed to update cart. Please try again.');
        }
    }

    public function removeItem($cart_item_uuid)
    {
        DB::beginTransaction();
        try {
            $cart_item = $this->cart_items->firstWhere('uuid', $cart_item_uuid);
            
            app('RemoveCartItemService')->execute([
                'cart_item_uuid' => $cart_item_uuid,
                'version' => $cart_item->version
            ], true);

            $this->loadCart();
            $this->showSuccessToast('Item removed from cart!');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage() ?: 'Failed to remove item. Please try again.');
        }
    }

    public function clearCart()
    {
        DB::beginTransaction();
        try {
            if (!$this->cart)
                throw new \Exception('No active cart to clear.');

            app('RemoveCartService')->execute([
                'cart_uuid' => $this->cart->uuid,
                'version' => $this->cart->version
            ], true);

            $this->loadCart();
            $this->showSuccessToast('Cart cleared successfully!');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage() ?: 'Failed to clear cart. Please try again.');
        }
    }

    public function checkout()
    {
        DB::beginTransaction();
        try {
            if (!$this->cart || $this->cart_items->isEmpty())
                throw new \Exception('Your cart is empty.');

            $order = app('CreateOrderService')->execute([
                'cart_uuid' => $this->cart->uuid
            ], true)['data'];

            $this->closeModal();
            $this->loadCart();
            $this->showSuccessToast('Order placed successfully! Order #' . $order->uuid);

            $this->dispatch('product-updated');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage() ?: 'Failed to checkout. Please try again.');
        }
    }

    private function calculateTotals()
    {
        $this->total_amount = $this->cart_items->sum('total_price');
        $this->item_count = $this->cart_items->sum('quantity');
    }

    public function render()
    {
        return view('livewire.components.cart-modal');
    }
}