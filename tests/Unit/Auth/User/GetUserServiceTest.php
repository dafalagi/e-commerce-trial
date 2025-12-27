<?php

namespace Tests\Unit\Auth\User;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_get()
    {
        $users = User::factory(2)->create();

        $dto = [];

        $result = app('GetUserService')->execute($dto);

        $this->assertEquals('User successfully fetched', $result['message']);
        $this->assertEquals(2, $result['data']->count());

        $this->assertEquals($users[0]->uuid, $result['data'][0]->uuid);
        $this->assertEquals($users[1]->uuid, $result['data'][1]->uuid);
    }
}
