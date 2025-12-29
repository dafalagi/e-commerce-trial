<?php

namespace App\Models\Order;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\BaseModel;

class Cart extends BaseModel
{
    protected $table = 'ord_carts';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:U',
            'updated_at' => 'datetime:U',
            'deleted_at' => 'datetime:U',

            'status' => CartStatus::class,
        ];
    }

    public function getRestrictOnDeleteRelations(): array
    {
        return [
            'cartItems',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
