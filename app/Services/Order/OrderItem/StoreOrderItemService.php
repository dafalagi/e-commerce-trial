<?php

namespace App\Services\Order\OrderItem;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreOrderItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new OrderItem;

        $model->order_id = $dto['order_id'];
        $model->product_id = $dto['product_id'];
        $model->product_name = $dto['product_name'];
        $model->quantity = $dto['quantity'];
        $model->price = $dto['price'];
        $model->total_price = $dto['total_price'];

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.order_item.stored');
    }

    public function prepare($dto)
    {
        if (isset($dto['order_uuid']))
            $dto['order_id'] = $this->findIdByUuid(Order::query(), $dto['order_uuid']);

        if (isset($dto['product_uuid']))
            $dto['product_id'] = $this->findIdByUuid(Product::query(), $dto['product_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'order_id' => ['nullable', 'integer', new ExistsId(new Order)],
            'order_uuid' => ['required_without:order_id', 'uuid', new ExistsUuid(new Order)],

            'product_id' => ['nullable', 'integer', new ExistsId(new Product)],
            'product_uuid' => ['required_without:product_id', 'uuid', new ExistsUuid(new Product)],

            'product_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
