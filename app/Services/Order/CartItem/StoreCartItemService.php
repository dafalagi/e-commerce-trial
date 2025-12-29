<?php

namespace App\Services\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreCartItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new CartItem;

        $model->cart_id = $dto['cart_id'];
        $model->product_id = $dto['product_id'];
        $model->quantity = $dto['quantity'];
        $model->price = $dto['price'];
        $model->total_price = $dto['total_price'];

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.cart_item.stored');
    }

    public function prepare($dto)
    {
        if (isset($dto['cart_uuid']))
            $dto['cart_id'] = $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);
            
        if (isset($dto['product_uuid']))
            $dto['product_id'] = $this->findIdByUuid(Product::query(), $dto['product_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_id' => ['nullable', 'integer', new ExistsId(new Cart)],
            'cart_uuid' => ['required_without:cart_id', 'uuid', new ExistsUuid(new Cart)],
            
            'product_id' => ['nullable', 'integer', new ExistsId(new Product)],
            'product_uuid' => ['required_without:product_id', 'uuid', new ExistsUuid(new Product)],
            
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
