<?php

namespace Tests\Unit\Auth\User;

use App\Models\Auth\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $user = User::factory()->create();

        $dto = [
            'user_id' => $user->id,
            'version' => 0,
        ];

        $result = app('DeleteUserService')->execute($dto);

        $this->assertEmpty($result['data']);
        $this->assertEquals('User successfully deleted', $result['message']);
    }

    public function test_fail_delete_version_not_match()
    {
        $user = User::factory()->create([
            'version' => 1,
        ]);

        $dto = [
            'user_id' => $user->id,
            'version' => 0,
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Version not match, please get the latest data and try again');
        $this->expectExceptionCode(409);

        app('DeleteUserService')->execute($dto, true);
    }
}
