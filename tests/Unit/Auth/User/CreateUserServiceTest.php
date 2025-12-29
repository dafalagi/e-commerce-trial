<?php

namespace Tests\Unit\Auth\User;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_create()
    {
        $role = Role::factory()->create();

        $dto = [
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_uuid' => $role->uuid,
        ];

        $result = app('CreateUserService')->execute($dto);

        $this->assertInstanceOf(User::class, $result['data']);
        $this->assertEquals('User successfully created.', $result['message']);
    }
}
