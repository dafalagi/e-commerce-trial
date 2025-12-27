<?php

namespace Tests\Unit\Auth\User;

use App\Models\Auth\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $user = User::factory()->create();

        $dto = [
            'user_id' => $user->id,
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'version' => 0,
        ];

        $result = app('UpdateUserService')->execute($dto);

        $this->assertInstanceOf(User::class, $result['data']);
        $this->assertEquals('User successfully updated', $result['message']);
    }

    public function test_fail_update_version_not_match()
    {
        $user = User::factory()->create([
            'version' => 1,
        ]);

        $dto = [
            'user_id' => $user->id,
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'version' => 0,
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Version not match, please get the latest data and try again');
        $this->expectExceptionCode(409);

        app('UpdateUserService')->execute($dto, true);
    }
}
