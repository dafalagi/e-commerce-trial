<?php

namespace Tests\Unit\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EditCartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_edit()
    {
        $cart = Cart::factory()->create();
        $user = User::factory()->create();
        $products = Product::factory(3)->create();

        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $products[0]->id,
            'quantity' => 2,
            'price' => 30.00,
            'total_price' => 60.00,
        ]);

        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $products[2]->id,
            'quantity' => 1,
            'price' => 20.00,
            'total_price' => 20.00,
        ]);

        $dto = [
            'cart_uuid' => $cart->uuid,
            'user_uuid' => $user->uuid,
            'version' => $cart->version,
            'items' => [
                [
                    'product_uuid' => $products[0]->uuid,
                    'quantity' => 1,
                    'price' => 30.00,
                    'total_price' => 30.00,
                ],
                [
                    'product_uuid' => $products[1]->uuid,
                    'quantity' => 2,
                    'price' => 20.00,
                    'total_price' => 40.00,
                ],
            ],
        ];

        $result = app('EditCartService')->execute($dto);

        $this->assertEquals('Cart successfully edited.', $result['message']);

        $this->assertDatabaseHas('ord_carts', [
            'uuid' => $result['data']->uuid,
            'user_id' => $user->id,
            'status' => CartStatus::ACTIVE->value,
            'total_price' => 70.00,
        ]);

        $this->assertDatabaseHas('ord_cart_items', [
            'cart_id' => $result['data']->id,
            'product_id' => $products[0]->id,
            'quantity' => 1,
            'price' => 30.00,
            'total_price' => 30.00,
        ]);

        $this->assertDatabaseHas('ord_cart_items', [
            'cart_id' => $result['data']->id,
            'product_id' => $products[1]->id,
            'quantity' => 2,
            'price' => 20.00,
            'total_price' => 40.00,
        ]);
    }
}
