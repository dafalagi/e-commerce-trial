<?php

namespace App\Services\Order\OrderItem;

use App\Models\Order\OrderItem;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteOrderItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = OrderItem::find($dto['order_item_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.order.order_item.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['order_item_uuid']))
            $dto['order_item_id'] = $this->findIdByUuid(OrderItem::query(), $dto['order_item_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'order_item_id' => ['nullable', 'integer', new ExistsId(new OrderItem)],
            'order_item_uuid' => ['required_without:order_item_id', 'uuid', new ExistsUuid(new OrderItem)],

            'version' => ['required', 'integer'],
        ];
    }
}
