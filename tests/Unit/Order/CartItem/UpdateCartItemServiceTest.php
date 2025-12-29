<?php

namespace Tests\Unit\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateCartItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $cart_item = CartItem::factory()->create();
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $dto = [
            'cart_item_uuid' => $cart_item->uuid,
            'cart_uuid' => $cart->uuid,
            'product_uuid' => $product->uuid,
            'quantity' => 2,
            'price' => 50.00,
            'total_price' => 100.00,
            'version' => $cart->version,
        ];

        $result = app('UpdateCartItemService')->execute($dto);

        $this->assertEquals('Cart Item successfully updated.', $result['message']);
    }
}
