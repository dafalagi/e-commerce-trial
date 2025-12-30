<?php

namespace App\Services\Order\Order;

use App\Enums\Order\CartStatus;
use App\Enums\Order\PaymentStatus;
use App\Jobs\SendLowStockNotification;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class CreateOrderService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        app('UpdateCartService')->execute([
            'cart_id' => $dto['cart']->id,
            'status' => CartStatus::CHECKED_OUT->value,
            'version' => $dto['cart']->version
        ], true);

        foreach ($dto['cart']->cartItems as $item) {
            if ($item->quantity > $item->product->stock)
                throw new \Exception("Sorry, {$item->product->name} has insufficient stock.");

            $new_stock = $item->product->stock - $item->quantity;
            app('UpdateProductService')->execute([
                'product_id' => $item->product->id,
                'stock' => $new_stock,
                'version' => $item->product->version
            ], true);

            if ($new_stock < 10) {
                $admins = User::whereHas('role', function ($query) {
                    $query->where('code', 'admin');
                })->get();

                foreach ($admins as $admin) {
                    SendLowStockNotification::dispatch([
                        'user_uuid' => $admin->uuid,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'stock_level' => $new_stock,
                    ]);
                }
            }
        }

        $order = app('StoreOrderService')->execute([
            'user_id' => $dto['cart']->user_id,
            'cart_id' => $dto['cart']->id,
            'payment_status' => $dto['payment_status'],
            'total_price' => $dto['cart']->total_price,
        ], true)['data'];

        foreach ($dto['cart']->cartItems as $cart_item) {
            app('StoreOrderItemService')->execute([
                'order_id' => $order->id,
                'product_id' => $cart_item->product_id,
                'product_name' => $cart_item->product->name,
                'quantity' => $cart_item->quantity,
                'price' => $cart_item->price,
                'total_price' => $cart_item->total_price,
            ], true);
        }

        $this->results['data'] = $order;
        $this->results['message'] = __('success.order.order.created');
    }

    public function prepare($dto)
    {
        $dto['cart'] = Cart::where('uuid', $dto['cart_uuid'])
            ->with('cartItems.product')
            ->first();

        $dto['payment_status'] = PaymentStatus::PAID->value;

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'cart_uuid' => ['required', 'uuid', new ExistsUuid(new Cart)],
        ];
    }
}
