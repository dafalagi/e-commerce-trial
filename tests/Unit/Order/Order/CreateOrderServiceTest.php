<?php

namespace Tests\Unit\Order\Order;

use App\Enums\Order\PaymentStatus;
use App\Models\Auth\User;
use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateOrderServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_create()
    {
        $user = User::factory()->create();
        $products = Product::factory(2)->create();

        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $cart_item_1 = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $products[0]->id,
        ]);
        $cart_item_2 = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $products[1]->id,
        ]);

        $dto = [
            'cart_uuid' => $cart->uuid,
        ];

        $result = app('CreateOrderService')->execute($dto);

        $this->assertEquals('Order successfully created.', $result['message']);

        $this->assertDatabaseHas('ord_orders', [
            'uuid' => $result['data']->uuid,
            'user_id' => $user->id,
            'payment_status' => PaymentStatus::PAID->value,
            'total_price' => $cart->total_price,
        ]);

        $this->assertDatabaseHas('ord_order_items', [
            'order_id' => $result['data']->id,
            'product_id' => $products[0]->id,
            'product_name' => $products[0]->name,
            'quantity' => $cart_item_1->quantity,
            'price' => $cart_item_1->price,
            'total_price' => $cart_item_1->total_price,
        ]);

        $this->assertDatabaseHas('ord_order_items', [
            'order_id' => $result['data']->id,
            'product_id' => $products[1]->id,
            'product_name' => $products[1]->name,
            'quantity' => $cart_item_2->quantity,
            'price' => $cart_item_2->price,
            'total_price' => $cart_item_2->total_price,
        ]);
    }
}
