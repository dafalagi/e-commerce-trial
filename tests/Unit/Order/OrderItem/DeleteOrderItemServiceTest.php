<?php

namespace Tests\Unit\Order\OrderItem;

use App\Models\Order\OrderItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteOrderItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $order_item = OrderItem::factory()->create();

        $dto = [
            'order_item_uuid' => $order_item->uuid,
            'version' => $order_item->version,
        ];

        $result = app('DeleteOrderItemService')->execute($dto);

        $this->assertEquals('Order Item successfully deleted.', $result['message']);
    }
}
