<?php

namespace Tests\Unit\Auth\Auth;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LogoutServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_success_logout()
    {
        $result = app('LogoutService')->execute([]);

        $this->assertEquals('User successfully logged out', $result['message']);
    }
}
