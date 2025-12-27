<?php

namespace App\Services\Product\Product;

use App\Models\Product\Product;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteProductService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Product::find($dto['product_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.product.product.deleted');
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

            'version' => ['required', 'integer'],
        ];
    }
}
