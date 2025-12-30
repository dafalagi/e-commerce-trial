<?php

namespace Tests\Unit\Order\Order;

use App\Models\Order\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteOrderServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $order = Order::factory()->create();

        $dto = [
            'order_uuid' => $order->uuid,
            'version' => $order->version,
        ];

        $result = app('DeleteOrderService')->execute($dto);

        $this->assertEquals('Order successfully deleted.', $result['message']);
    }
}
