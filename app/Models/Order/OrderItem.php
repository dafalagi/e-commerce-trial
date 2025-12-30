<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Product\Product;

class OrderItem extends BaseModel
{
    protected $table = 'ord_order_items';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
