<?php

namespace App\Services\Product\Product;

use App\Models\Product\Product;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetProductService extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'updated_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = Product::orderBy($dto['sort_by'], $dto['sort_type']);

        // Add secondary sort by id to ensure consistent ordering
        if ($dto['sort_by'] !== 'id') {
            $model->orderBy('id', 'desc');
        }

        if (isset($dto['with'])) {
            $model->with($dto['with']);
        }

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where('name','ILIKE','%'.$dto['search_param'].'%')
                  ->orWhere('description','ILIKE','%'.$dto['search_param'].'%');
        }

        if (isset($dto['product_uuid']) and $dto['product_uuid'] != '') {
            $model->where('uuid', $dto['product_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }

        $this->results['message'] = __('success.product.product.fetched');
        $this->results['data'] = $data;
    }
}
