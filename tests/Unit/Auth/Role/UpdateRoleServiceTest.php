<?php

namespace Tests\Unit\Auth\Role;

use App\Models\Auth\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $role = Role::factory()->create([
            'version' => 0,
        ]);

        $dto = [
            'role_id' => $role->id,
            'name' => 'Updated Role',
            'code' => 'updated_role',
            'description' => 'This is an updated role',
            'version' => 0,
        ];

        $result = app('UpdateRoleService')->execute($dto);

        $this->assertInstanceOf(Role::class, $result['data']);
        $this->assertEquals('Role successfully updated.', $result['message']);
        $this->assertEquals('Updated Role', $result['data']->name);
    }
}
