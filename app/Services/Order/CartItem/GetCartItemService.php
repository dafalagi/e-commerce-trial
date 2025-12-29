<?php

namespace App\Services\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetCartItemService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'updated_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = CartItem::orderBy($dto['sort_by'], $dto['sort_type']);

        if ($dto['sort_by'] !== 'id') {
            $model->orderBy('id', 'desc');
        }

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['cart_id']) or isset($dto['cart_uuid'])) {
            $cart_id = $dto['cart_id'] ?? $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);
            $model->where('cart_id', $cart_id);
        }

        if (isset($dto['cart_item_uuid']) and $dto['cart_item_uuid'] != '') {
            $model->where('uuid', $dto['cart_item_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.order.cart_item.fetched');
        $this->results['data'] = $data;
    }
}
