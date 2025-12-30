<?php

namespace App\Services\Order\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class CreateOrderService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $order = app('StoreOrderService')->execute([
            'user_id' => $dto['cart']->user_id,
            'cart_id' => $dto['cart']->id,
            'payment_status' => $dto['payment_status'],
            'total_price' => $dto['cart']->total_price,
        ], true)['data'];

        foreach ($dto['cart']->cartItems as $cart_item) {
            app('StoreOrderItemService')->execute([
                'order_id' => $order->id,
                'product_id' => $cart_item->product_id,
                'product_name' => $cart_item->product->name,
                'quantity' => $cart_item->quantity,
                'price' => $cart_item->price,
                'total_price' => $cart_item->total_price,
            ], true);
        }

        $this->results['data'] = $order;
        $this->results['message'] = __('success.order.order.created');
    }

    public function prepare($dto)
    {
        $dto['cart'] = Cart::where('uuid', $dto['cart_uuid'])
            ->with('cartItems.product')
            ->first();

        $dto['payment_status'] = PaymentStatus::PAID->value;

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_uuid' => ['required', 'uuid', new ExistsUuid(new Cart)],
        ];
    }
}
