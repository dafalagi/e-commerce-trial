<?php

namespace App\Services\Order\Cart;

use App\Models\Order\Cart;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class RemoveCartService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        if ($dto['cart']->cartItems->count() > 0) {
            foreach ($dto['cart']->cartItems as $cart_item) {
                app('DeleteCartItemService')->execute([
                    'cart_item_id' => $cart_item->id,
                    'version' => $cart_item->version,
                ], true);
            }
        }

        app('DeleteCartService')->execute([
            'cart_id' => $dto['cart']->id,
            'version' => $dto['version'],
        ], true);

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.cart.removed');
    }

    public function prepare($dto)
    {
        $dto['cart'] = Cart::where('uuid', $dto['cart_uuid'])
            ->with('cartItems')
            ->first();

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_uuid' => ['required', 'uuid', new ExistsUuid(new Cart)],

            'version' => ['required', 'integer'],
        ];
    }
}
