<?php

namespace Tests\Unit\Auth\Role;

use App\Models\Auth\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $role = Role::factory()->create([
            'version' => 0,
        ]);

        $dto = [
            'role_id' => $role->id,
            'version' => 0,
        ];

        $result = app('DeleteRoleService')->execute($dto);

        $this->assertEmpty($result['data']);
        $this->assertEquals('Role successfully deleted.', $result['message']);
    }
}
