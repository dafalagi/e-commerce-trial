<?php

namespace Tests\Unit\Auth\UserRole;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RemoveUserRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_remove()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        UserRole::factory()->create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $dto = [
            'user_uuid' => $user->uuid,
            'role_uuid' => $role->uuid,
        ];

        $result = app('RemoveUserRoleService')->execute($dto);

        $this->assertEquals($result['message'], "Role successfully removed from User.");
    }
}
