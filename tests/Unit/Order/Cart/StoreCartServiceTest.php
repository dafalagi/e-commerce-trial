<?php

namespace Tests\Unit\Order\Cart;

use App\Enums\Order\CartStatus;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreCartServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $user = User::factory()->create();

        $dto = [
            'user_uuid' => $user->uuid,
            'status' => CartStatus::ACTIVE->value,
            'total_price' => 100.00,
        ];

        $result = app('StoreCartService')->execute($dto);

        $this->assertEquals('Cart successfully stored.', $result['message']);
    }
}
