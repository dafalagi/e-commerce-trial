<?php

namespace App\Services\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Models\Product\Product;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class EditCartService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $cart = app('UpdateCartService')->execute([
            'cart_id' => $dto['cart']->id,
            'user_uuid' => $dto['user_uuid'],
            'status' => $dto['status'],
            'total_price' => $dto['total_price'],
            'version' => $dto['version'],
        ], true)['data'];

        $new_items = array_map(fn($item) => $item['product_uuid'], $dto['items']);
        $old_items = $dto['cart']->cartItems->map(fn($item) => $item->product->uuid)->toArray();

        $added_items = array_diff($new_items, $old_items);
        $removed_items = array_diff($old_items, $new_items);

        foreach ($removed_items as $product_uuid) {
            $cart_item = $dto['cart']->cartItems->firstWhere('product.uuid', $product_uuid);

            app('DeleteCartItemService')->execute([
                'cart_item_id' => $cart_item->id,
                'version' => $cart_item->version,
            ], true);
        }

        foreach ($dto['items'] as $item) {
            if (in_array($item['product_uuid'], $added_items)) {
                app('StoreCartItemService')->execute([
                    'cart_id' => $cart->id,
                    'product_uuid' => $item['product_uuid'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ], true);
            } else {
                $cart_item = $dto['cart']->cartItems->firstWhere('product.uuid', $item['product_uuid']);

                app('UpdateCartItemService')->execute([
                    'cart_item_id' => $cart_item->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'version' => $cart_item->version,
                ], true);
            }
        }

        $this->results['data'] = $cart;
        $this->results['message'] = __('success.order.cart.edited');
    }

    public function prepare($dto)
    {
        $dto['cart'] = Cart::where('uuid', $dto['cart_uuid'])
            ->with('cartItems.product')
            ->first();

        $dto['status'] = CartStatus::ACTIVE->value;
        $dto['total_price'] = collect($dto['items'])->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_uuid' => ['required', 'uuid', new ExistsUuid(new Cart)],
            'user_uuid' => ['required', 'uuid', new ExistsUuid(new User)],

            'version' => ['required', 'integer'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_uuid' => ['required', 'uuid', new ExistsUuid(new Product)],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
