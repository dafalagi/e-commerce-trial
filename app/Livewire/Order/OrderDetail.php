<?php

namespace App\Livewire\Order;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderDetail extends Component
{
    use WithToast;

    public $order_uuid;
    public $order;
    public $order_items;

    public function mount($order_uuid)
    {
        $this->order_uuid = $order_uuid;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        try {
            $result = app('GetOrderService')->execute([
                'order_uuid' => $this->order_uuid,
                'user_uuid' => Auth::user()->uuid,
                'with' => ['orderItems']
            ], true);

            if (!$result['data']) {
                $this->order = null;
                $this->order_items = collect();
                return;
            }

            $this->order = $result['data'];

            $items_result = app('GetOrderItemService')->execute([
                'order_uuid' => $this->order_uuid,
                'sort_by' => 'created_at',
                'sort_type' => 'asc',
                'with' => ['product']
            ], true);

            $this->order_items = $items_result['data'];
        } catch (\Exception $e) {
            $this->order = null;
            $this->order_items = collect();
            $this->showErrorToast('Error loading order details.');
        }
    }

    public function reorder()
    {
        DB::beginTransaction();
        try {
            if (!$this->order || !$this->order_items || $this->order_items->isEmpty()) {
                DB::rollBack();
                $this->showErrorToast('No items found to reorder.');
                return;
            }

            $cart_result = app('GetCartService')->execute([
                'user_uuid' => Auth::user()->uuid,
                'status' => 'active',
                'with' => ['cartItems.product']
            ], true);

            $items = [];
            foreach ($this->order_items as $item) {
                $items[] = [
                    'product_uuid' => $item->product->uuid,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ];
            }

            if ($cart_result['data']->isEmpty()) {
                app('CreateCartService')->execute([
                    'user_uuid' => Auth::user()->uuid,
                    'items' => $items
                ], true);
            } else {
                $cart = $cart_result['data']->first();
                $existing_items = $cart->cartItems->map(function($item) {
                    return [
                        'product_uuid' => $item->product->uuid,
                        'quantity' => $item->quantity,
                        'price' => $item->price
                    ];
                })->toArray();

                foreach ($items as $new_item) {
                    $found = false;
                    foreach ($existing_items as $index => $existing_item) {
                        if ($existing_item['product_uuid'] === $new_item['product_uuid']) {
                            $existing_items[$index]['quantity'] += $new_item['quantity'];
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $existing_items[] = $new_item;
                    }
                }

                app('EditCartService')->execute([
                    'cart_uuid' => $cart->uuid,
                    'user_uuid' => Auth::user()->uuid,
                    'version' => $cart->version,
                    'items' => $existing_items
                ], true);
            }

            $this->showSuccessToast('All items added to cart successfully!');
            $this->dispatch('cart-updated');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast('Failed to add items to cart. Please try again.');
        }
    }

    public function backToOrders()
    {
        $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.order.order-detail');
    }
}