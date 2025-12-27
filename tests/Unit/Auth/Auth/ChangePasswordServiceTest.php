<?php

namespace Tests\Unit\Auth\Auth;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ChangePasswordServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_success_change_password()
    {
        $dto = [
            'email' => $this->user->email,
            'old_password' => 'password',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
            'version' => 0,
        ];

        $result = app('ChangePasswordService')->execute($dto);

        $this->assertEquals('User successfully changed password', $result['message']);
        $this->assertEquals($this->user->email, $result['data']['user']['email']);
        $this->assertEquals($this->user->uuid, $result['data']['user']['uuid']);
        
        $this->assertTrue(Hash::check('newpassword', $this->user->fresh()->password));
    }

    public function test_fail_invalid_old_password()
    {
        $dto = [
            'email' => $this->user->email,
            'old_password' => 'wrongpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
            'version' => 0,
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid old password');
        $this->expectExceptionCode(401);

        app('ChangePasswordService')->execute($dto, true);
    }

    public function test_fail_same_old_and_new_password()
    {
        $dto = [
            'email' => $this->user->email,
            'old_password' => 'password',
            'new_password' => 'password',
            'new_password_confirmation' => 'password',
            'version' => 0,
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('New password must be different from old password');
        $this->expectExceptionCode(400);

        app('ChangePasswordService')->execute($dto, true);
    }
}
