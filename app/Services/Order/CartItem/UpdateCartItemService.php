<?php

namespace App\Services\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateCartItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = CartItem::find($dto['cart_item_id']);

        $model->cart_id = $dto['cart_id'] ?? $model->cart_id;
        $model->product_id = $dto['product_id'] ?? $model->product_id;
        $model->quantity = $dto['quantity'] ?? $model->quantity;
        $model->price = $dto['price'] ?? $model->price;
        $model->total_price = $dto['total_price'] ?? $model->total_price;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.cart_item.updated');
    }

    public function prepare($dto)
    {
        if (isset($dto['cart_item_uuid']))
            $dto['cart_item_id'] = $this->findIdByUuid(CartItem::query(), $dto['cart_item_uuid']);

        if (isset($dto['cart_uuid']))
            $dto['cart_id'] = $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);
            
        if (isset($dto['product_uuid']))
            $dto['product_id'] = $this->findIdByUuid(Product::query(), $dto['product_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_item_id' => ['nullable', 'integer', new ExistsId(new CartItem)],
            'cart_item_uuid' => ['required_without:cart_item_id', 'uuid', new ExistsUuid(new CartItem)],

            'cart_id' => ['nullable', 'integer', new ExistsId(new Cart)],
            'cart_uuid' => ['nullable', 'uuid', new ExistsUuid(new Cart)],
            
            'product_id' => ['nullable', 'integer', new ExistsId(new Product)],
            'product_uuid' => ['nullable', 'uuid', new ExistsUuid(new Product)],

            'quantity' => ['nullable', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'total_price' => ['nullable', 'numeric', 'min:0'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
