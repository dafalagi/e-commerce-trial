<?php

namespace App\Models\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\BaseModel;

class Order extends BaseModel
{
    protected $table = 'ord_orders';

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime:U',
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function getRestrictOnDeleteRelations(): array
    {
        return [
            'orderItems',
        ];
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
