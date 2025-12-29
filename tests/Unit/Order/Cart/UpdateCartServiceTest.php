<?php

namespace Tests\Unit\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateCartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $cart = Cart::factory()->create();
        $user = User::factory()->create();

        $dto = [
            'cart_uuid' => $cart->uuid,
            'user_uuid' => $user->uuid,
            'status' => CartStatus::ACTIVE->value,
            'total_price' => 100.00,
            'version' => $cart->version,
        ];

        $result = app('UpdateCartService')->execute($dto);

        $this->assertEquals('Cart successfully updated.', $result['message']);
    }
}
