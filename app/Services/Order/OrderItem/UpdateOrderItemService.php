<?php

namespace App\Services\Order\OrderItem;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateOrderItemService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = OrderItem::find($dto['order_item_id']);

        $model->order_id = $dto['order_id'] ?? $model->order_id;
        $model->product_id = $dto['product_id'] ?? $model->product_id;
        $model->product_name = $dto['product_name'] ?? $model->product_name;
        $model->quantity = $dto['quantity'] ?? $model->quantity;
        $model->price = $dto['price'] ?? $model->price;
        $model->total_price = $dto['total_price'] ?? $model->total_price;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.order_item.updated');
    }

    public function prepare($dto)
    {
        if (isset($dto['order_item_uuid']))
            $dto['order_item_id'] = $this->findIdByUuid(OrderItem::query(), $dto['order_item_uuid']);

        if (isset($dto['order_uuid']))
            $dto['order_id'] = $this->findIdByUuid(Order::query(), $dto['order_uuid']);

        if (isset($dto['product_uuid']))
            $dto['product_id'] = $this->findIdByUuid(Product::query(), $dto['product_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'order_item_id' => ['nullable', 'integer', new ExistsId(new OrderItem)],
            'order_item_uuid' => ['required_without:order_item_id', 'uuid', new ExistsUuid(new OrderItem)],

            'order_id' => ['nullable', 'integer', new ExistsId(new Order)],
            'order_uuid' => ['nullable', 'uuid', new ExistsUuid(new Order)],

            'product_id' => ['nullable', 'integer', new ExistsId(new Product)],
            'product_uuid' => ['nullable', 'uuid', new ExistsUuid(new Product)],

            'product_name' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'total_price' => ['nullable', 'numeric', 'min:0'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
