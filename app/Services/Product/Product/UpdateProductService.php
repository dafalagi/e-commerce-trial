<?php

namespace App\Services\Product\Product;

use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateProductService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Product::find($dto['product_id']);

        $model->name = $dto['name'] ?? $model->name;
        $model->description = $dto['description'] ?? $model->description;
        $model->price = $dto['price'] ?? $model->price;
        $model->stock = $dto['stock'] ?? $model->stock;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.product.product.updated');
    }

    public function prepare($dto)
    {
        if(isset($dto['product_uuid']))
            $dto['product_id'] = $this->findIdByUuid(Product::query(), $dto['product_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'product_id' => ['nullable', 'integer', new ExistsId(new Product)],
            'product_uuid' => ['required_without:product_id', 'uuid', new ExistsUuid(new Product)],

            'name' => ['nullable', 'string', new UniqueData('prd_products', 'name', $dto['product_id'] ?? $dto['product_uuid'])],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
