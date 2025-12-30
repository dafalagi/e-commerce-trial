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
            'created_at' => 'datetime:U',
            'updated_at' => 'datetime:U',
            'deleted_at' => 'datetime:U',

            'payment_status' => PaymentStatus::class,
        ];
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
