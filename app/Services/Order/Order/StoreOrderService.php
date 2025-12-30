<?php

namespace App\Services\Order\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Validation\Rule;

class StoreOrderService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new Order;

        $model->user_id = $dto['user_id'];
        $model->cart_id = $dto['cart_id'];
        $model->payment_status = $dto['payment_status'];
        $model->total_price = $dto['total_price'] ?? 0;

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.order.stored');
    }

    public function prepare($dto)
    {
        if (isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        if (isset($dto['cart_uuid']))
            $dto['cart_id'] = $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'cart_id' => ['nullable', 'integer', new ExistsId(new Cart)],
            'cart_uuid' => ['required_without:cart_id', 'uuid', new ExistsUuid(new Cart)],

            'payment_status' => ['required', Rule::enum(PaymentStatus::class)],
            'total_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
