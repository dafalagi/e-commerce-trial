<?php

namespace App\Services\Order\Cart;

use App\Models\Order\Cart;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetCartService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'updated_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = Cart::orderBy($dto['sort_by'], $dto['sort_type']);

        // Add secondary sort by id to ensure consistent ordering
        if ($dto['sort_by'] !== 'id') {
            $model->orderBy('id', 'desc');
        }

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where('status','ILIKE','%'.$dto['search_param'].'%');
        }

        if (isset($dto['cart_uuid']) and $dto['cart_uuid'] != '') {
            $model->where('uuid', $dto['cart_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.order.cart.fetched');
        $this->results['data'] = $data;
    }
}
