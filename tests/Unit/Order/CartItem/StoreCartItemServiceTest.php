<?php

namespace Tests\Unit\Order\CartItem;

use App\Models\Order\Cart;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreCartItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $dto = [
            'cart_uuid' => $cart->uuid,
            'product_uuid' => $product->uuid,
            'quantity' => 2,
            'price' => 50.00,
            'total_price' => 100.00,
        ];

        $result = app('StoreCartItemService')->execute($dto);

        $this->assertEquals('Cart Item successfully stored.', $result['message']);
    }
}
