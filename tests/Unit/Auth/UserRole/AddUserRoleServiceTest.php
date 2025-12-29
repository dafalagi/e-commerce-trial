<?php

namespace Tests\Unit\Auth\UserRole;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AddUserRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_add()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $dto = [
            'user_uuid' => $user->uuid,
            'role_uuid' => $role->uuid,
        ];

        $result = app('AddUserRoleService')->execute($dto);

        $this->assertEquals($result['message'], "Role successfully added to User.");
    }
}
