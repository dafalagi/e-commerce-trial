<?php

namespace Tests\Unit\Order\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreOrderServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create();

        $dto = [
            'user_uuid' => $user->uuid,
            'cart_uuid' => $cart->uuid,
            'payment_status' => PaymentStatus::PAID->value,
            'total_price' => 100.00,
        ];

        $result = app('StoreOrderService')->execute($dto);

        $this->assertEquals('Order successfully stored.', $result['message']);
    }
}
