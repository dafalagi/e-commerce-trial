<?php

namespace App\Livewire\Order;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    use WithToast;

    public $orderUuid;
    public $order;
    public $orderItems;

    public function mount($orderUuid)
    {
        $this->orderUuid = $orderUuid;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        if (!Auth::check()) {
            $this->redirect(route('auth.login'));
            return;
        }

        $result = app('GetOrderService')->execute([
            'order_uuid' => $this->orderUuid,
            'user_uuid' => Auth::user()->uuid,
            'with' => []
        ], true);

        if (!$result['data']) {
            $this->showErrorToast('Order not found or access denied.');
            $this->redirect(route('products.index'));
            return;
        }

        $this->order = $result['data'];

        // Get order items
        $itemsResult = app('GetOrderItemService')->execute([
            'order_uuid' => $this->orderUuid,
            'sort_by' => 'created_at',
            'sort_type' => 'asc',
            'with' => []
        ], true);

        $this->orderItems = $itemsResult['data'];
    }

    public function reorder()
    {
        // Add all items from this order back to cart
        foreach ($this->orderItems as $item) {
            try {
                app('CreateCartService')->execute([
                    'user_uuid' => Auth::user()->uuid,
                    'product_uuid' => $item->product->uuid,
                    'quantity' => $item->quantity,
                ], true);
            } catch (\Exception $e) {
                // Continue if one item fails
            }
        }

        $this->showSuccessToast('Items added to cart successfully!');
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.order.order-detail');
    }
}