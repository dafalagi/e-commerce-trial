<?php

namespace App\Services\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\Product\Product;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class CreateCartService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $cart = app('StoreCartService')->execute([
            'user_uuid' => $dto['user_uuid'],
            'status' => $dto['status'],
            'total_price' => $dto['total_price'],
        ], true)['data'];

        foreach ($dto['items'] as $item) {
            app('StoreCartItemService')->execute([
                'cart_id' => $cart->id,
                'product_uuid' => $item['product_uuid'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
            ], true);
        }

        $this->results['data'] = $cart;
        $this->results['message'] = __('success.order.cart.created');
    }

    public function prepare($dto)
    {
        $dto['status'] = CartStatus::ACTIVE->value;
        $dto['total_price'] = collect($dto['items'])->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid(new User)],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_uuid' => ['required', 'uuid', new ExistsUuid(new Product)],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
