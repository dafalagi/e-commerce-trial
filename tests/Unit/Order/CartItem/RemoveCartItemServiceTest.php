<?php

namespace Tests\Unit\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RemoveCartItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $cart = Cart::factory()->create();
        $cart_item = CartItem::factory()->create([
            'cart_id' => $cart->id,
        ]);

        $dto = [
            'cart_item_uuid' => $cart_item->uuid,
            'version' => $cart_item->version,
        ];

        $result = app('RemoveCartItemService')->execute($dto);

        $this->assertEquals('Cart Item successfully removed.', $result['message']);

        $this->assertDatabaseHas('ord_cart_items', [
            'id' => $cart_item->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('ord_carts', [
            'id' => $cart->id,
            'is_active' => false,
        ]);
    }
}
