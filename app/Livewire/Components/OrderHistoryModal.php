<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class OrderHistoryModal extends Component
{
    public $is_open = false;
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    #[On('toggle-order-history')]
    public function toggleModal()
    {
        $this->is_open = !$this->is_open;
        
        if ($this->is_open) {
            $this->loadOrders();
        }
    }

    public function closeModal()
    {
        $this->is_open = false;
    }

    public function loadOrders()
    {
        if (!Auth::check()) {
            $this->orders = collect();
            return;
        }

        $result = app('GetOrderService')->execute([
            'user_uuid' => Auth::user()->uuid,
            'sort_by' => 'created_at',
            'sort_type' => 'desc',
            'per_page' => 50,
            'with' => ['orderItems'],
            'with_pagination' => true
        ], true);

        $this->orders = $result['data'];
    }

    public function viewOrderDetail($order_uuid)
    {
        $this->redirect(route('orders.show', $order_uuid), navigate: true);
    }

    public function render()
    {
        return view('livewire.components.order-history-modal');
    }
}
