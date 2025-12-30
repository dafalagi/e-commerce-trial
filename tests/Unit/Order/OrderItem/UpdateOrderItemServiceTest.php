<?php

namespace Tests\Unit\Order\OrderItem;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateOrderItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $order_item = OrderItem::factory()->create();
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $dto = [
            'order_item_uuid' => $order_item->uuid,
            'order_uuid' => $order->uuid,
            'product_uuid' => $product->uuid,
            'product_name' => $product->name,
            'quantity' => 3,
            'price' => $product->price,
            'total_price' => $product->price * 3,
            'total_price' => 100.00,
            'version' => $order->version,
        ];

        $result = app('UpdateOrderItemService')->execute($dto);

        $this->assertEquals('Order Item successfully updated.', $result['message']);
    }
}
