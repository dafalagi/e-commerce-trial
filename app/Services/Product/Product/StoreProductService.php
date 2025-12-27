<?php

namespace App\Services\Product\Product;

use App\Models\Product\Product;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreProductService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new Product;

        $model->name = $dto['name'];
        $model->description = $dto['description'] ?? null;
        $model->price = $dto['price'];
        $model->stock = $dto['stock'];

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.product.product.stored');
    }

    public function prepare($dto)
    {
        return $dto;
    }

    public function rules($dto)
    {
        return [
            'name' => ['required', 'string', new UniqueData('prd_products', 'name')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }
}
