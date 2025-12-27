<?php

namespace Tests\Unit\Auth\Role;

use App\Models\Auth\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $dto = [
            'name' => 'Test Role',
            'code' => 'test_role',
            'description' => 'This is a test role',
        ];

        $result = app('StoreRoleService')->execute($dto);

        $this->assertInstanceOf(Role::class, $result['data']);
        $this->assertEquals('Role successfully stored', $result['message']);
        $this->assertEquals('Test Role', $result['data']->name);
    }
}
