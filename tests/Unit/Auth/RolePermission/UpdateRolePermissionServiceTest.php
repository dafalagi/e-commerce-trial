<?php

namespace Tests\Unit\Auth\RolePermission;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\RolePermission;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateRolePermissionServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();
        RolePermission::factory()->create([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);

        $dto = [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ];

        $result = app('UpdateRolePermissionService')->execute($dto);

        $this->assertEquals('Role Permission successfully updated', $result['message']);
    }

    public function test_success_store()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $dto = [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ];

        $result = app('UpdateRolePermissionService')->execute($dto);

        $this->assertEquals('Role Permission successfully updated', $result['message']);
    }
}
