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
            'cart_uuid' => ['required', 'uuid', new ExistsUuid(new User)],
        ];
    }
}
