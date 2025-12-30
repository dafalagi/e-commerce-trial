<?php

namespace Tests\Unit\Order\Cart;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RemoveCartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_remove()
    {
        $cart = Cart::factory()->create();
        CartItem::factory(3)->create(['cart_id' => $cart->id]);

        $dto = [
            'cart_uuid' => $cart->uuid,
            'version' => $cart->version,
        ];

        $result = app('RemoveCartService')->execute($dto);

        $this->assertEquals('Cart successfully removed.', $result['message']);
    }
}
