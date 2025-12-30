<?php

namespace App\Services\Order\OrderItem;

use App\Models\Auth\User;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetOrderItemService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'updated_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = OrderItem::orderBy($dto['sort_by'], $dto['sort_type']);

        // Add secondary sort by id to ensure consistent ordering
        if ($dto['sort_by'] !== 'id') {
            $model->orderBy('id', 'desc');
        }

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where('product_name','ILIKE','%'.$dto['search_param'].'%');
        }

        if (isset($dto['order_id']) or isset($dto['order_uuid'])) {
            $order_id = $dto['order_id'] ?? $this->findIdByUuid(Order::query(), $dto['order_uuid']);
            $model->where('order_id', $order_id);
        }

        if (isset($dto['order_item_uuid']) and $dto['order_item_uuid'] != '') {
            $model->where('uuid', $dto['order_item_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.order.order_item.fetched');
        $this->results['data'] = $data;
    }
}
