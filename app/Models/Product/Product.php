<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use App\Models\Order\CartItem;

class Product extends BaseModel
{
    protected $table = 'prd_products';

    public function getRestrictOnDeleteRelations(): array
    {
        return [
            'cartItems',
        ];
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }
}
