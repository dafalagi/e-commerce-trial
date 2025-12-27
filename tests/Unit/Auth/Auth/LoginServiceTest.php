<?php

namespace Tests\Unit\Auth\Auth;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan(
            'passport:client',
            ['--name' => 'BookingGrandiaAccessToken', '--personal' => null]
        );

        $this->user = User::factory()->create([
            'email' => 'customer@wangun.co',
            'password' => bcrypt('password'),
        ]);
        $role = Role::factory()->create([
            'code' => 'customer',
        ]);
        UserRole::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_success_login()
    {
        $dto = [
            'email' => 'customer@wangun.co',
            'password' => 'password',
        ];

        $result = app('LoginService')->execute($dto);

        $this->assertEquals('User successfully logged in', $result['message']);
        $this->assertEquals($this->user->uuid, $result['data']['user']['uuid']);
        $this->assertEquals($this->user->email, $result['data']['user']['email']);
        $this->assertNotNull($result['data']['token']);
    }
}
