<?php

namespace App\Services\Order\CartItem;

use App\Models\Order\CartItem;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteCartItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = CartItem::find($dto['cart_item_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.cart_item.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['cart_item_uuid']))
            $dto['cart_item_id'] = $this->findIdByUuid(CartItem::query(), $dto['cart_item_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_item_id' => ['nullable', 'integer', new ExistsId(new CartItem)],
            'cart_item_uuid' => ['required_without:cart_item_id', 'uuid', new ExistsUuid(new CartItem)],

            'version' => ['required', 'integer'],
        ];
    }
}
