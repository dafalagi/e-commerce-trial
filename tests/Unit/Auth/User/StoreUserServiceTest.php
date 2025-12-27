<?php

namespace Tests\Unit\Auth\User;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $dto = [
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $result = app('StoreUserService')->execute($dto);

        $this->assertInstanceOf(User::class, $result['data']);
        $this->assertEquals('User successfully stored', $result['message']);
    }
}
