<?php

namespace Tests\Unit\Order\OrderItem;

use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreOrderItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $dto = [
            'order_uuid' => $order->uuid,
            'product_uuid' => $product->uuid,
            'product_name' => $product->name,
            'quantity' => 2,
            'price' => $product->price,
            'total_price' => $product->price * 2,
        ];

        $result = app('StoreOrderItemService')->execute($dto);

        $this->assertEquals('Order Item successfully stored.', $result['message']);
    }
}
