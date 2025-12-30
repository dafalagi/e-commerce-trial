<?php

namespace App\Services\Order\Order;

use App\Models\Order\Order;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteOrderService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Order::find($dto['order_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.order.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['order_uuid']))
            $dto['order_id'] = $this->findIdByUuid(Order::query(), $dto['order_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'order_id' => ['nullable', 'integer', new ExistsId(new Order)],
            'order_uuid' => ['required_without:order_id', 'uuid', new ExistsUuid(new Order)],

            'version' => ['required', 'integer'],
        ];
    }
}
