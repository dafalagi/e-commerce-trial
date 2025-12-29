<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Product\Product;

class CartItem extends BaseModel
{
    protected $table = 'ord_cart_items';

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
