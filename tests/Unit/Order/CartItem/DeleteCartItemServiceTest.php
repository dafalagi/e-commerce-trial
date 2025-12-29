<?php

namespace Tests\Unit\Order\CartItem;

use App\Models\Order\CartItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteCartItemServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $cart_item = CartItem::factory()->create();

        $dto = [
            'cart_item_uuid' => $cart_item->uuid,
            'version' => $cart_item->version,
        ];

        $result = app('DeleteCartItemService')->execute($dto);

        $this->assertEquals('Cart Item successfully deleted.', $result['message']);
    }
}
