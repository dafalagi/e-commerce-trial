<?php

namespace App\Services\Order\CartItem;

use App\Models\Order\CartItem;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class RemoveCartItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        app('DeleteCartItemService')->execute([
            'cart_item_uuid' => $dto['cart_item_uuid'],
            'version' => $dto['version'],
        ], true);

        if ($dto['cart']->cartItems->count() === 0) {
            app('DeleteCartService')->execute([
                'cart_id' => $dto['cart']->id,
                'version' => $dto['cart']->version,
            ], true);
        }

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.cart_item.removed');
    }

    public function prepare($dto)
    {
        $dto['cart'] = CartItem::where('uuid', $dto['cart_item_uuid'])
            ->first()
            ->cart;

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_item_uuid' => ['required', 'uuid', new ExistsUuid(new CartItem)],

            'version' => ['required', 'integer'],
        ];
    }
}
