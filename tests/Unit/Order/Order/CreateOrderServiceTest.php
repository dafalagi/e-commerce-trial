<?php

namespace Tests\Unit\Order\Order;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
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

        $dto = [
            'user_uuid' => $user->uuid,
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

        $result = app('CreateCartService')->execute($dto);

        $this->assertEquals('Cart successfully created.', $result['message']);

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
