<?php

namespace Tests\Unit\Order\Cart;

use App\Models\Order\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteCartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $cart = Cart::factory()->create();

        $dto = [
            'cart_uuid' => $cart->uuid,
            'version' => $cart->version,
        ];

        $result = app('DeleteCartService')->execute($dto);

        $this->assertEquals('Cart successfully deleted.', $result['message']);
    }
}
