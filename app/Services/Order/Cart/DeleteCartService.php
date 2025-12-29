<?php

namespace App\Services\Order\Cart;

use App\Models\Order\Cart;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteCartService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Cart::find($dto['cart_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.cart.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['cart_uuid']))
            $dto['cart_id'] = $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_id' => ['nullable', 'integer', new ExistsId(new Cart)],
            'cart_uuid' => ['required_without:cart_id', 'uuid', new ExistsUuid(new Cart)],

            'version' => ['required', 'integer'],
        ];
    }
}
