<?php

namespace App\Services\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Validation\Rule;

class StoreCartService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new Cart;

        $model->user_id = $dto['user_id'];
        $model->status = $dto['status'];
        $model->total_price = $dto['total_price'] ?? 0;

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.cart.stored');
    }

    public function prepare($dto)
    {
        if (isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'status' => ['required', Rule::enum(CartStatus::class)],
            'total_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
