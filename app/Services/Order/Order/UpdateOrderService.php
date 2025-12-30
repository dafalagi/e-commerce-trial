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

class UpdateOrderService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Order::find($dto['order_id']);

        $model->user_id = $dto['user_id'] ?? $model->user_id;
        $model->cart_id = $dto['cart_id'] ?? $model->cart_id;
        $model->payment_status = $dto['payment_status'] ?? $model->payment_status;
        $model->total_price = $dto['total_price'] ?? $model->total_price;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.order.order.updated');
    }

    public function prepare($dto)
    {
        if (isset($dto['cart_uuid']))
            $dto['cart_id'] = $this->findIdByUuid(Cart::query(), $dto['cart_uuid']);

        if (isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'order_id' => ['nullable', 'integer', new ExistsId(new Order)],
            'order_uuid' => ['required_without:order_id', 'uuid', new ExistsUuid(new Order)],

            'cart_id' => ['nullable', 'integer', new ExistsId(new Cart)],
            'cart_uuid' => ['nullable', 'uuid', new ExistsUuid(new Cart)],

            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['nullable', 'uuid', new ExistsUuid(new User)],

            'payment_status' => ['nullable', Rule::enum(PaymentStatus::class)],
            'total_price' => ['nullable', 'numeric', 'min:0'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
