<?php

namespace Tests\Unit\Order\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateOrderServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $order = Order::factory()->create();
        $cart = Cart::factory()->create();
        $user = User::factory()->create();

        $dto = [
            'order_uuid' => $order->uuid,
            'cart_uuid' => $cart->uuid,
            'user_uuid' => $user->uuid,
            'payment_status' => PaymentStatus::PAID->value,
            'total_price' => 100.00,
            'version' => $order->version,
        ];

        $result = app('UpdateOrderService')->execute($dto);

        $this->assertEquals('Order successfully updated.', $result['message']);
    }
}
